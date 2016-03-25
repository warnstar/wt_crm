<?php

namespace common\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "medical_group_user".
 *
 * @property integer $id
 * @property integer $medical_group_id
 * @property integer $user_id
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $create_time
 */
class Medical_group_user extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medical_group_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medical_group_id', 'user_id'], 'required'],
            [['medical_group_id', 'user_id', 'start_time', 'end_time', 'create_time','next_visit','last_visit'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medical_group_id' => 'Medical Group ID',
            'user_id' => 'User ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'next_visit'=>"Next_visit",
            'last_visit'=>'Last_visit',
            'create_time' => 'Create Time',
        ];
    }
    public function search($option = null){
        $query = $this->find();

        $select = [
            'medical_group_user.*',

            'user_name'=>'users.name',
            'user_sex'=>'users.sex',
            'user_birth'=>'users.birth',
            'user_passport'=>'users.passport',

            'brand_id'              =>  'b.id',
            'brand_name'            =>  'b.name'
        ];
        $query->select($select);


        if($option){
            //待访问客户
            if(isset($option['un_visit']) && $option['un_visit']){
                //当前处于疗程
                //当前时间（算今天结束后的时间）
                $this_time = time();
                $query->andWhere("medical_group_user.start_time <= $this_time && medical_group_user.end_time > $this_time");

                //获取待访问的（当前时间小于要访问的时间）
                $query->andWhere("medical_group_user.next_visit <= $this_time");

                //未访问过，
                $query->orWhere("medical_group_user.last_visit = 0");

            }

            //获取有待访客户的品牌。
            if(isset($option['un_visit_brand']) && $option['un_visit_brand']){
                $query->groupBy('brand_id');
            }

            //筛选用户参加的
            if(isset($option['user_id']) && $option['user_id']){
                $query->andWhere(['medical_group_user.user_id'=>(int)$option['user_id']]);
            }

            //筛选品牌
            if(isset($option['brand_id']) && $option['brand_id']){
                $query->andWhere(['b.id'=>(int)$option['brand_id']]);
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

            //筛选某医疗团下所有的成员
            if(isset($option['medical_group_id']) && $option['medical_group_id']){
                $query->andWhere(['medical_group_user.medical_group_id'=>(int)$option['medical_group_id']]);
            }

            //搜索(护照号，姓名，手机号，病历号）
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                //$search_num = (int)$search;
                $query->andWhere("users.passport  LIKE '%$search%' OR users.name LIKE '%$search%' OR users.phone LIKE '%$search%' OR users.cases_code LIKE '%$search%'");
            }

        }


        $query->leftJoin(['users'],'medical_group_user.user_id=users.id')
            ->leftJoin(['mg'=>'medical_group'],'medical_group_user.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id');


        $pages = new Pagination([
            'totalCount'    => $query->count(),
            'pageSize'      => 9,
        ]);
        $query->offset($pages->offset)
            ->limit($pages->limit);


        $list = $query->asArray()->all();

        $data['list'] = $list;
        $data['pages'] = $pages;

        return $data;
    }

    //待访客户
    public function un_visit_users($option = null){
        //brand_id,
        $option['un_visit'] = true;


        $data = $this->search($option);

        return $data;
    }


    //获取有待访客户的品牌
    /**
     * @param null $option
     * @return array 返回客服列表
     */
    public function un_visit_brands($option = null){

        $option['un_visit'] = true;
        $option['un_visit_brand'] = true;

        $res = $this->search($option);
        $workers = [];
        if(isset($res['list']) && $res['list']){
            foreach($res['list'] as $v){
                $workers[]  = (new Worker())->find()->where(['brand_id'=>$v['brand_id'],'role_id'=>2])->asArray()->one();
            }
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


    //疗程详情
    public function detail($id){
        $query = $this->find();

        $select = [
            'users.*',
            'medical_group_user.*',
            'brand_id'              =>  'b.id',
            'brand_name'            =>  'b.name',
            'group_name'            =>  'mg.name'
        ];
        $query->select($select);

        $query->andWhere(['medical_group_user.id'=>$id]);

        $query->leftJoin(['users'],'medical_group_user.user_id=users.id')
            ->leftJoin(['mg'=>'medical_group'],'medical_group_user.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id');

        $data = $query->asArray()->one();

        return $data;
    }

    public function exist(){
        $data = $this->find()->where(['medical_group_id'=>$this->medical_group_id,'user_id'=>$this->user_id])->one();

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

    public function excel_data($medical_group_id){
        // “	姓名	 性别	手机号	护照号	出生年月（mm/dd/YY)	HN	品牌	 所属区域  ”
        $title = [
            '姓名',
            '性别',
            '手机号',
            '护照号',
            '出生年月',
            'HN',
            '品牌',
            '所属区域'
        ];

        $query = $this->find();

        $select = [
            'user_name'             =>'users.name',
            'user_sex'              =>'users.sex',
            'user_phone'            =>'users.phone',
            'user_passport'         =>'users.passport',
            'user_birth'            =>'users.birth',
            'user_cases_code'       =>'users.cases_code',
            'brand_name'            =>  'b.name',
            'area_name'             =>  'a.name'
        ];
        $query->select($select);

        $query->where(['medical_group_user.medical_group_id'=>$medical_group_id]);

        $query->leftJoin(['users'],'medical_group_user.user_id=users.id')
            ->leftJoin(['mg'=>'medical_group'],'medical_group_user.medical_group_id=mg.id')
            ->leftJoin(['b'=>'brand'],'mg.brand_id=b.id')
            ->leftJoin(['a'=>'area'],'users.area_id=a.id');

        $res = $query->asArray()->all();

        $res_deal = [];
        //数据处理
        if($res){
            //转换数据视图
            foreach($res as $k=>$v){
                $res[$k]['user_sex'] = ( $v['user_sex'] == 1 ? "男" : "女" );
                $res[$k]['user_birth'] = date("m/d/Y",$v['user_birth']);

            }

            //去除数组键名
            foreach($res as $k=>$v){
                foreach($v as $kk=>$vv){
                    $res_deal[$k][] = $vv;
                }
            }
        }


        $data['excel_data'] = $res_deal;
        $data['excel_title'] = $title;

        $group = (new Medical_group())->find()->select('name')->where(['id'=>$medical_group_id])->asArray()->one();
        if($group){
            $data['excel_name'] = $group['name'];
        }
        return $data;
    }

    public function create($post){

        $this->medical_group_id = isset($post['group_id']) ? $post['group_id'] : null;
        $this->user_id = isset($post['user_id']) ? $post['user_id'] : null;
        $this->end_time = isset($post['end_time']) ? (int)$post['end_time']: null;
        $this->create_time = time();

        $group = (new Medical_group())->find()->where(['id'=>$this->medical_group_id])->one();

        if($group && $this->user_id) {
            $this->start_time = $group->end_time;

            //之前保存的结束时间是天，规则是开始后的第几天。
            $this->end_time = $this->start_time + $this->end_time * 3600 * 24;

            //写入疗程开始后的下次回访时间
            $this->next_visit = $this->start_time + 3600 * 24;

            if ($this->exist()) {
                return null;
            } else {
                if ($this->save()) {

                    //修改用户最后一次参团与品牌
                    $user = (new Users())->find()->where(['id' => $this->user_id])->one();
                    if($user){
                        $user->brand_id = $group->brand_id;
                        $user->last_mgu = $this->id;
                        $flag['user_mgu'] = $user->save();
                    }

                    //修改医疗团用户数
                    $user_count = (new Medical_group_user())->find()->where(['medical_group_id' => $this->medical_group_id])->count("*");
                    $group->user_count = $user_count;
                    $flag['group_count'] = $group->save();

                    return (new Users())->find()->where(['id'=>$user->id])->asArray()->one();
                }
            }
        }
        return null;
    }

    public function delete_this($id = 0){

        $data = (new Medical_group_user())->find()->where(['id'=>$id])->one();

        if(!$data){
            $msg['code'] = 3;
            $msg['error'] = "要删除用户对象不存在!";
            return $msg;
        }

        $group = (new Medical_group())->find()->where(['id'=>$data->medical_group_id])->one();

        if(!isset($msg)){
            if($data->delete()){
                $msg['code'] = 0;

                //删除回访记录
                $visits = (new Visit())->find()->where(['mgu_id'=>$id])->asArray()->all();
                if($visits){
                    foreach($visits as $v){

                        $flag['visits'] = (new Visit())->delete_this($v['id']);
                    }
                }

                //删除未匹配的备注
                $notes = (new Note())->find()->where(['mgu_id'=>$id])->asArray()->all();
                if($notes){
                    foreach($notes as $v){
                        $flag['notes'] = (new Note())->delete_this($v['id']);
                    }
                }

                //修改医疗团用户数
                if($group){
                    $user_count = (new Medical_group_user())->find()->where(['medical_group_id'=>$group->id])->count("*");
                    $group->user_count = $user_count;
                    $flag['group_count'] = $group->save();
                }

            }else{
                $msg['code'] = 6;
                $msg['error'] = "数据库操作失败！";
            }
        }

        return $msg;
    }
}