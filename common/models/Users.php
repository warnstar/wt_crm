<?php

namespace common\models;

use Yii;
use yii\data\Pagination;
/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $passport
 * @property integer $birth
 * @property string $phone
 * @property integer $sex
 * @property integer $status
 * @property integer $cases_code
 * @property integer $area_id
 * @property string $wechat
 * @property integer $create_time
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'passport'], 'required'],
            [['birth', 'sex', 'status', 'area_id', 'create_time','brand_id'], 'integer'],
            [['name','birth_day', 'passport','cases_code', 'phone', 'wechat'], 'string', 'max' => 255]
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
            'passport' => 'Passport',
            'birth' => 'Birth',
            'birth_day'=>'Birth_day',
            'phone' => 'Phone',
            'sex' => 'Sex',
            'cases_code'=>'Cases_code',
            'status' => 'Status',
            'brand_id'=>'Brand_id',
            'area_id' => 'Area ID',
            'wchat' => 'Wchat',
            'create_time' => 'Create Time',
        ];
    }

    /**
     *
     *
     *
     * 筛选（区域，省份，医疗团）
     * 搜索（护照号，手机号，病历号）
     * @param null $option
     */
    public function search($option = null,$page = true){
        $query = $this->find();

        $select = [
            'users.*',
            'end_time_mgu'          => 'mgu.end_time',
            'start_time_mgu'        =>  'mgu.start_time',
            'group_name'            =>  'mg.name',
            'brand_name'            =>  'b.name',
            'area_name'             =>  'a.name'
        ];
        $query->select($select);


        if($option){

            //筛选品牌
            if(isset($option['brand_id']) && $option['brand_id']){
                $query->andWhere(['users.brand_id'=>(int)$option['brand_id']]);
            }
            //筛选区域
            if(isset($option['area_id']) && $option['area_id']){
                $query->andWhere(['users.area_id'=>(int)$option['area_id']]);
            }
            //筛选上级区域
            if(isset($option['area_higher_id']) && $option['area_higher_id']){
                $area_higher_id = $option['area_higher_id'];
                $query->andWhere("users.area_id in (select id FROM area WHERE parent_id = $area_higher_id)");
            }


            //筛选医疗团(最后一次参加）
            if(isset($option['medical_group_id']) && $option['medical_group_id']){
                $query->andWhere(['mg.id'=>(int)$option['medical_group_id']]);
            }

            //搜索(护照号，手机号，病历号）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("users.passport  LIKE '%$search%' OR users.name LIKE '%$search%' OR users.phone LIKE '%$search%' OR users.cases_code LIKE '%$search%'");
            }

            //未参加某医疗团
            if(isset($option['un_join_group']) && $option['un_join_group']){
                $un_join_group = (int)$option['un_join_group'];
                $query->andWhere("users.id NOT IN ( select user_id from medical_group_user WHERE medical_group_id = $un_join_group)");
            }
        }


        $query->leftJoin(['mgu'=>'medical_group_user'],'users.last_mgu=mgu.id')
            ->leftJoin(['mg'=>'medical_group'],'mgu.medical_group_id=mg.id')
            ->leftJoin(['mgu_all'=>'medical_group_user'],'users.id=mgu_all.user_id')
            ->leftJoin(['a'=>'area'],'users.area_id=a.id')
            ->leftJoin(['b'=>'brand'],'users.brand_id=b.id');

        $query->groupBy("id");

        /**
         * 是否进行分页
         */
        if($page){
            $pages = new Pagination([
                'totalCount'    => $query->count(),
                'pageSize'      => 9,
            ]);
            $query->offset($pages->offset)
                ->limit($pages->limit);


            $list = $query->asArray()->all();

            $data['list'] = $list;
            $data['pages'] = $pages;
        }else{
            $data['list'] = $query->asArray()->all();
        }

        return $data;
    }

    /**
     * 获取今天生日的用户
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getBirthDayUsers(){
        $query = $this->find();
        $birth_day = date("md",time());

        $query->andWhere("birth_day = $birth_day");


        $data = $query->asArray()->all();

        return $data;
    }


    public function detail($id){
        $query = $this->find();

        $select = [
            'users.*',
            'end_time_mgu'          => 'mgu.end_time',
            'start_time_mgu'        =>  'mgu.start_time',
            'group_name'            =>  'mg.name',
            'brand_id'              =>  'b.id',
            'brand_name'            =>  'b.name',
            'brand_attention'       =>  'b.attention'
        ];
        $query->select($select);

        $query->where(['users.id'=>$id]);

        $query->leftJoin(['mgu'=>'medical_group_user'],'users.last_mgu=mgu.id')
            ->leftJoin(['mg'=>'medical_group'],'mgu.medical_group_id=mg.id')
            ->leftJoin(['mgu_all'=>'medical_group_user'],'users.id=mgu_all.user_id')
            ->leftJoin(['b'=>'brand'],'users.brand_id=b.id');

        $data = $query->asArray()->one();


        return $data;
    }

    public function create_data($post = []){
        $user = new Users();

        $user->name = isset($post['name']) ? $post['name'] : null;
        $user->sex = isset($post['sex']) ? $post['sex'] : null;
        $user->phone = isset($post['phone']) ? $post['phone'] : null;
        $user->passport = isset($post['passport']) ? $post['passport'] : null;

        $user->birth = isset($post['birth']) ? $post['birth'] : null;
        $user->birth_day = date("md",$user->birth);
        $user->cases_code = isset($post['cases_code']) ? $post['cases_code'] : null;
        $user->brand_id = isset($post['brand_id']) ? (int)$post['brand_id'] : null;
        $user->area_id = isset($post['area_id']) ? (int)$post['area_id'] : null;
        $user->create_time = time();


        if($user->exist()){
            return null;
        }else{

            if($user->save(false)){
                return $this->find()->where(['id'=>$user->id])->asArray()->one();
            }else{
                return null;
            }
        }
    }

    public function exist(){
        //护照号和病历号不能重名
        $data = $this->find()->where(['passport'=>$this->passport])->orWhere(['cases_code'=>$this->cases_code])->one();

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

    public function delete_this($id = 0){

        $data = (new Users())->find()->where(['id'=>$id])->one();

        if(!$data){
            $msg['code'] = 3;
            $msg['error'] = "要删除用户对象不存在!";
            return $msg;
        }



        if(!isset($msg)){
            if($data->delete()){
                $msg['code'] = 0;

                //删除参团
                $mgus = (new Medical_group_user())->find()->where(['user_id'=>$id])->asArray()->all();
                if($mgus){
                    foreach($mgus as $v){

                        $flag['mgus'] = (new Medical_group_user())->delete_this($v['id']);
                    }
                }

                //删除第三方绑定
                $extras = (new UsersExtra())->find()->where(['user_id'=>$id])->all();
                if($extras){
                    foreach($extras as $v){
                        $flag['extras'][] = $v->delete();
                    }
                }
            }else{
                $msg['code'] = 6;
                $msg['error'] = "数据库操作失败！";
            }
        }

        return $msg;
    }
}
