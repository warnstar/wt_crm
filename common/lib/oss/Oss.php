<?php
namespace common\lib\oss;


/**
 * 阿里云文件服务器api
 */
include "oss_service/sdk.class.php";

class Oss{
	private $oss;
	const BUCKET = 'wtcrm';

	public function __construct(){
		$this->oss = new \ALIOSS();
	}

	// 上传文件，自动处理
	public function file_auto($field){
		$res = $this->file_upload($field);
		if($res['error']){
			$msg['status'] = 0;
			$msg['errors'][$field] = $res['error'];
			exit(json_encode($msg));
		}

		return $res['url'];
	}

	// 上传文件
	public function file_upload($field){
		$result = array('error' => null, 'url' => '');

		if(empty($_FILES[$field]['name'])){
			$result['error'] = '请选择文件';
			return $result;
		}

		$info = $_FILES[$field];

		$name = date('YmdHis') . '#'  . uniqid() . '#'  . $info['name'];

		$res = $this->oss->upload_file_by_file(self::BUCKET, $name, $info['tmp_name']);

		if($res){
			$result['url'] = $res->header['_info']['url'];
			$result['url_object'] = $name;
		}else{
			$result['error'] = '上传失败，请重试';
		}

		return $result;
	}

	// 获取文件列表
	public function file_list(){
		return $this->oss->list_object(self::BUCKET);
	}

	// 删除文件
	public function file_del($url){
		return  $this->oss->delete_object(self::BUCKET, $url);
	}
}