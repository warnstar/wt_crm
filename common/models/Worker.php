<?php

namespace common\models;
use yii\data\Pagination;

/**
 * This is the model class for table "worker".
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $phone
 * @property integer $sex
 * @property integer $role_id
 * @property string $wchat
 * @property integer $brand_id
 * @property integer $area_id
 * @property integer $create_time
 */
class Worker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'worker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'role_id', 'brand_id', 'area_id','status', 'create_time'], 'integer'],
            [['role_id'], 'required'],
            [['name', 'password', 'phone', 'wechat'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'password' => 'Password',
            'phone' => 'Phone',
            'sex' => 'Sex',
            'role_id' => 'Role ID',
            'wechat' => 'Wechat',
            'brand_id' => 'Brand ID',
            'area_id' => 'Area ID',
            'status'    =>'Status',
            'create_time' => 'Create Time',
        ];
    }

    public function detail($id){
        $query = $this->find();

        $select = [
            'worker.*',
            'brand_name'=>'b.name',
            'area_name'=>'a.name',
            'role_name'=>'r.name'
        ];
        $query->select($select);

        $query->andWhere(['status'=>1]);
        $query->andWhere("worker.id = :id",[':id'=>$id]);


        $query->leftJoin(['a'=>'area'],'worker.area_id=a.id')
            ->leftJoin(['b'=>'brand'],'worker.brand_id=b.id')
            ->leftJoin(['r'=>'worker_role'],'worker.role_id=r.id');


        $data = $query->asArray()->one();

        return $data;
    }

    public function login(){
        $option['status'] = 1;

        $option['phone'] = $this->phone;
        $worker = (new Worker())->find()->andWhere($option)->one();

        if($worker && $worker->password == $this->password){

            return $worker;
        }else{
            false;
        }
    }
    /**
     *
     *
     *
     * 筛选（区域，省份，品牌，角色）
     * 搜索（手机号，名字）
     * @param null $option
     * @param false  (默认返回数据数组，可选返回provider)
     */
    public function search($option = null,$is_provider = false){
        $query = $this->find();

        $select = [
            'worker.*',
            'brand_name'=>'b.name',
            'area_name'=>'a.name',
            'role_name'=>'r.name'
        ];
        $query->select($select);

        $query->andWhere(['status'=>1]);
        $query->andWhere("worker.role_id > :role_id",[':role_id'=>1]);

        if($option){

            //筛选品牌
            if(isset($option['brand_id']) && $option['brand_id']){
                $query->andWhere(['worker.brand_id'=>(int)$option['brand_id']]);
            }
            //筛选区域
            if(isset($option['area_id']) && $option['area_id']){
                $query->andWhere(['worker.area_id'=>(int)$option['area_id']]);
            }
            //筛选上级区域
            if(isset($option['area_higher_id']) && $option['area_higher_id']){
                $area_higher_id = $option['area_higher_id'];
                $query->andWhere("worker.area_id in (select id FROM area WHERE parent_id = $area_higher_id)");
            }
            //筛选角色
            if(isset($option['role_id']) && $option['role_id']){
                $query->andWhere(['worker.role_id'=>(int)$option['role_id']]);
            }



            // 搜索（手机号，名字）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("worker.phone  LIKE '%$search%' OR worker.name LIKE '%$search%'");
            }
        }


        $query->leftJoin(['a'=>'area'],'worker.area_id=a.id')
            ->leftJoin(['b'=>'brand'],'worker.brand_id=b.id')
            ->leftJoin(['r'=>'worker_role'],'worker.role_id=r.id');


        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'  => 9,
            'route' => "worker/list_ajax"
        ]);
        $query->offset($pages->offset)
            ->limit($pages->limit);


        $list = $query->asArray()->all();

        $data['list'] = $list;
        $data['pages'] = $pages;
        return $data;
    }

    public function find_by_phone($phone){
        //过滤禁用的
        $option['status']= 1;

        $option['phone'] = $phone;
        $worker = $this->find()->where($option)->asArray()->one();
        return $worker;
    }

    public function getRoleWorker($roles = '',$mgu_id){
        if(!$roles || !$mgu_id){
            return null;
        }

        $mgu = (new Medical_group_user())->find()->where(['id'=>$mgu_id])->one();
        $flag= [];
        if(!$mgu){
            $flag['mgu'] = $mgu;
            return null;
        }

        $group = (new Medical_group())->find()->where(['id'=>$mgu->medical_group_id])->one();
        if(!$group){
            $flag['group'] = $group;
            return null;
        }

        $user = (new Users)->find()->where(['id'=>$mgu->user_id])->one();
        if(!$user){
            $flag['user'] = $user;
            return null;
        }

        $workers = [];

        //过滤禁用的
        $option['status']= 1;

        //限制品牌
        $option['brand_id'] = $group->brand_id;
        //获取对接人员
        if(strlen(strpos($roles,'3'))){
            $option['role_id'] = 3;
            $workers[] = (new Worker())->find()->where($option)->asArray()->one();
        }
        //获取品牌经理
        if(strlen(strpos($roles,'4'))){
            $option['role_id'] = 4;
            $workers[] = (new Worker())->find()->where($option)->asArray()->one();
        }
        //获取区域经理
        if(strlen(strpos($roles,'5'))){
            $option['role_id'] = 5;
            $area_higher_id = (new Area())->find()->select('parent_id')->where(['id'=>$user->area_id])->asArray()->one();
            $option['a.parent_id'] = $area_higher_id;

            $workers[] = (new Worker())->find()->select('worker.*')->andWhere($option)->leftJoin(['a'=>'area'],'worker.area_id=a.id')->asArray()->one();

            unset($option['a.parent_id']);
        }
        //获取大区经理
        if(strlen(strpos($roles,'6'))){
            $option['role_id'] = 6;
            $option['area_id'] = $user->area_id;
            $workers[] = (new Worker())->find()->where($option)->asArray()->one();
        }

        //处理，除去null的
        $data = [];
        if($workers) foreach($workers as $v){
           if($v){
               $data[] = $v;
           }
        }

        return $data;
    }

    public function delete_this($id){

        $data = (new Worker())->findOne($id);
        if(!$data){
            $msg['code'] = 3;
            $msg['error'] = "要删除用户对象不存在!";
            return $msg;
        }

        if(!isset($msg)){
            $brand = (new Brand())->findOne($data->brand_id);
            if($data->delete()){
                if($brand){
                    $brand->manager_id = null;
                    $brand->save();
                }
                $msg['code'] = 0;
            }else{
                $msg['code'] = 6;
                $msg['error'] = "数据库操作失败！";
            }
        }

        return $msg;
    }


    public function WeChatLogin($phone,$password){
        if(!$phone || !$password){
            $msg['code'] = 5;
            $msg['error'] = "账户密码不能为空！";
            return $msg;
        }

        $worker = (new Worker())->find()->where(['phone'=>$phone,'password'=>$password])->andWhere("role_id IN (2,3,4,5,6)")->one();
        if($worker){
            $msg['code'] = 0;
            $msg['info'] = $worker;
        }else{
            $msg['code'] = 8;
            $msg['error'] = "账户或密码错误";
        }

        return $msg;
    }
    /**
     * 获取职员的权限区域
     * @return int|mixed
     */
    public function getRangeArea($id){

        $worker = $this->findOne($id);

        $area_id = 0;
        switch ($worker->role_id){
            case 2 :
                //客服
                break;
            case 3 :
                //对接人员
                break;
            case 4 :
                //品牌经理
                break;
            case 5 :
                //区域总监
                $this_area = (new Area())->find()->where(['id'=>$worker->area_id])->one();
                $area_id = $this_area->parent_id;
                break;
            case 6 :
                //大区经理
                $area_id = $worker->area_id;
                break;
            default :
                break;
        }
        
        return $area_id;
    }
    public function exist(){
        $data = $this->findOne(['phone'=>$this->phone]);
        if($data){
            if($this->id){
                if($data->id == $this->id){
                    return false;
                }
            }
            return true;
        }else{
            return false;
        }
    }
}
