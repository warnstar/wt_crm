<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/28
 * Time: 14:47
 */
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title></title>
	<script src="js/mui.min.js"></script>
	<link href="css/mui.min.css" rel="stylesheet"/>

	<!--loading 显示-->
	<link rel="stylesheet" type="text/css" href="css/my.css"/>
	<script src="js/my.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript" charset="utf-8">
		mui.init();
	</script>
	<style>
		.area {
			margin: 20px auto 0px auto;
		}
		.mui-input-group {
			margin-top: 10px;
		}
		.mui-input-group:first-child {
			margin-top: 20px;
		}
		.mui-input-group label {
			width: 26%;
			text-align: right;
		}
		.mui-input-row label~input,
		.mui-input-row label~select,
		.mui-input-row label~textarea {
			width: 74%;

		}
		.mui-checkbox input[type=checkbox],
		.mui-radio input[type=radio] {
			top: 6px;
		}
		.mui-content-padded {
			margin-top: 25px;
		}
		.mui-btn {
			padding: 10px;
		}
		.link-area {
			display: block;
			margin-top: 25px;
			text-align: center;
		}
		.spliter {
			color: #bbb;
			padding: 0px 8px;
		}
		.oauth-area {
			position: absolute;
			bottom: 20px;
			left: 0px;
			text-align: center;
			width: 100%;
			padding: 0px;
			margin: 0px;
		}
		.oauth-area .oauth-btn {
			display: inline-block;
			width: 50px;
			height: 50px;
			background-size: 30px 30px;
			background-position: center center;
			background-repeat: no-repeat;
			margin: 0px 20px;
			/*-webkit-filter: grayscale(100%); */

			border: solid 1px #ddd;
			border-radius: 25px;
		}
		.oauth-area .oauth-btn:active {
			border: solid 1px #aaa;
		}
		.logo img{
			width: 100px;
			height: 100px;
			margin: 0 auto;
			display: block;
		}
		.logo{
			margin-top: 50px;
		}
	</style>
</head>
<body>
<h1 class="logo">
	<img src="images/logo.png"/>
</h1>
<div class="mui-content">
	<form id='login-form' class="mui-input-group">
		<div class="mui-input-row">
			<label>护照号</label>
			<input id='passport' type="text" class="mui-input-clear mui-input passport_data" placeholder="请输入护照号">
		</div>
		<div class="mui-input-row">
			<label>姓名</label>
			<input id='name' type="text" class="mui-input-clear mui-input name_data" placeholder="请输入姓名">
		</div>
	</form>

	<div class="mui-content-padded">
		<button id='login' class="mui-btn mui-btn-block mui-btn-primary commit_click">搜索</button>

	</div>
	<div class="mui-content-padded oauth-area">
		<font color="#aaa" size='1'>广州唯托生物科技有限公司</font>
	</div>
</div>
<script src="js/mui.min.js"></script>
<script src="js/jquery-2.2.2.min.js"></script>
</body>
</html>

<script>
	$("body").on("click",".commit_click",function(){
		var url = "<?=\yii\helpers\Url::toRoute("outsource/check_save")?>";
		var data = {
			passport :   $(".passport_data").val(),
			name    :   $(".name_data").val(),
			_csrf   :   "<?=Yii::$app->request->csrfToken?>"
		};

		$.post(url,data,function(msg){
			console.log(msg);
			if(msg.status){
				location.href = msg.url;
			}else{
				alert(msg.error);
			}
		},'json');
	});
</script>