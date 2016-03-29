<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/29
 * Time: 10:15
 */

namespace common\lib;


class MyHelp
{
	public function isWeChat(){
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return true;
		}
		return false;
	}
}