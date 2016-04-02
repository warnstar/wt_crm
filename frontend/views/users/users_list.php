<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>查询</title>

	<script src="js/mui.min.js"></script>
	<script src="js/mui.picker.js"></script>
	<script src="js/mui.poppicker.js"></script>
	<link href="css/mui.min.css" rel="stylesheet" />
	<link href="css/mui.picker.css" rel="stylesheet" />
	<link href="css/mui.poppicker.css" rel="stylesheet" />

	<script src="js/jquery-2.2.2.min.js"></script>
	<script type="text/javascript" charset="UTF-8">
		var mui_data = {
			medical_groups  :   <?=$medical_groups?>,
			areas           :   <?=$areas?>
		};
		(function($, doc) {
			$.init();
			$.ready(function() {
				var cityPicker = new $.PopPicker({
					layer: 2
				});
				cityPicker.setData(mui_data.areas);
				var showCityPickerButton = doc.getElementById('sheng');
				var cityResult = doc.getElementById('sheng');
				showCityPickerButton.addEventListener('tap', function(event) {
					cityPicker.show(function(items) {
						if(items[1].value){
							cityResult.innerText =  items[0].text + " " + items[1].text;
						}else{
							cityResult.innerText =  items[0].text;
						}
						area_filter(items[0].value,items[1].value);

						//返回 false 可以阻止选择框的关闭
						//return false;
					});
				}, false);

				//-----------------------
				var tuanPicker = new $.PopPicker({
					layer: 1
				});
				tuanPicker.setData(mui_data.medical_groups);

				var showTuanPickerButton = doc.getElementById('tuan');
				var TuanResult = doc.getElementById('tuan');
				showTuanPickerButton.addEventListener('tap', function(event) {

					tuanPicker.show(function(items) {
						TuanResult.innerText =  items[0].text;
						group_filter(items[0].value);
						//返回 false 可以阻止选择框的关闭
						//return false;
					});
				}, false);
			});
		})(mui, document);
	</script>
	<style>
		.title {
			margin: 20px 15px 10px;
			color: #6d6d72;
			font-size: 15px;
		}

		.oa-contact-cell.mui-table .mui-table-cell {
			padding: 11px 0;
			vertical-align: middle;
		}

		.oa-contact-cell {
			position: relative;
			margin: -11px 0;
		}

		.oa-contact-avatar {
			width: 75px;
		}

		.oa-contact-avatar img {
			border-radius: 50%;
		}

		.oa-contact-content {
			width: 100%;
		}

		.oa-contact-name {
			margin-right: 20px;
		}

		.oa-contact-name,
		oa-contact-position {
			float: left;
		}

		#login-form {
			margin-top: 30%;
		}

		#login {
			margin-top: 30px;
			width: 80%;
			margin-left: auto;
			margin-right: auto;
			padding: 10px;
		}

		.h-xuanzhe {
			width: 50%;
			display: block;
			float: left;
			text-align: center;
			line-height: 44px;
			font-size: 14px;
		}
		.h-title{
			list-style: none;
			padding: none;
		}
		.h-title{
			list-style: none;
			padding: 0;
			margin: 0;
		}
		.h-row{

			float: left;
			text-overflow: ellipsis;
			overflow: hidden;
		}
		.w25{
			width: 25%;
		}
		.w5{
			width: 15%;
		}
		.mui-table-view-chevron .mui-table-view-cell{
			padding-right: 30px;
		}
		.mui-navigate-right:after, .mui-push-right:after{
			right: 40px;
		}
		//--------
		  .mui-bar-tab .mui-tab-item1 {
			  display: table-cell;
			  overflow: hidden;
			  width: 1%;
			  height: 50px;
			  text-align: center;
			  vertical-align: middle;
			  white-space: nowrap;
			  text-overflow: ellipsis;
			  color: #929292;
			  float: left;
		  }

		.mui-bar-tab .mui-tab-item1.mui-active1 {
			color: #007aff;
		}

		.mui-bar-tab .mui-tab-item1 .mui-icon {
			top: 3px;
			width: 24px;
			height: 24px;
			padding-top: 0;
			padding-bottom: 0;
		}

		.mui-bar-tab .mui-tab-item1 .mui-icon ~ .mui-tab-label {
			font-size: 11px;
			display: block;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.mui-bar-tab .mui-tab-item1 .mui-icon:active {
			background: none;
		}
		.mui-tab-item1.mui-plus-hidden, .mui-tab-item1.mui-wechat-hidden
		{
			display: table-cell !important;
		}
		.mui-bar-tab .mui-tab-item1
		{
			display: table-cell;
			overflow: hidden;

			width: 1%;
			height: 50px;

			text-align: center;
			vertical-align: middle;
			white-space: nowrap;
			text-overflow: ellipsis;

			color: #929292;
		}
	</style>
</head>

<body>
<header class="mui-bar mui-bar-nav">
	<span class="h-xuanzhe" id="sheng">所有区域</span>
	<span class="h-xuanzhe" id='tuan'>所有出团</span>
</header>

<nav class="mui-bar mui-bar-tab">
	<nav class="mui-bar mui-bar-tab">
		<?php $role_id = Yii::$app->session->get("role_id");?>

		<?php if($role_id == 2):?>
			<a class="mui-tab-item1" href="<?=\yii\helpers\Url::toRoute("visit/un_visit_list")?>">
				<span class="mui-icon mui-icon-star"></span>
				<span class="mui-tab-label">待仿</span>
			</a>
		<?php endif;?>

		<?php if($role_id == 3):?>
			<a class="mui-tab-item1" href="<?=\yii\helpers\Url::toRoute("visit/error_un_do")?>">
				<span class="mui-icon mui-icon-bars"></span>
				<span class="mui-tab-label">待处理</span>
			</a>
		<?php endif;?>

		<a class="mui-tab-item1 " href="<?=\yii\helpers\Url::toRoute("users/search")?>">
			<span class="mui-icon mui-icon-search"></span>
			<span class="mui-tab-label">查询</span>
		</a>

		<a class="mui-tab-item1 mui-active1" href="<?=\yii\helpers\Url::toRoute("users/list")?>">
			<span class="mui-icon mui-icon-bars"></span>
			<span class="mui-tab-label">所有</span>
		</a>
	</nav>
</nav>
<div class="mui-content">

	<ul class="mui-table-view mui-table-view-chevron">


		<?php if($users) foreach($users as $v):?>
		<li class="mui-table-view-cell">
			<a href="<?=\yii\helpers\Url::toRoute("users/detail_worker") . "&user_id=" . $v['id']?>" class="mui-navigate-right">
				<span id="name" class="h-row w25"><?=$v['name']?></span>
				<span id="sex"  class="h-row w5"><?=$v['sex'] == 1 ? "男" : "女"?></span>
				<span id="sex"  class="h-row w25"><?=$v['area_name']?></span>
				<span id="status"  class="h-row w25">
					<?php
					if(!$v['last_mgu'])
						echo "无疗程";
					else if($v['start_time_mgu'] > time()){
						echo "未开始";
					}
					else if($v['end_time_mgu'] < time()){
						echo "已结束";
					}else{
						echo "疗程中";
					}
					?>
				</span>
			</a>
		</li>
		<?php endforeach;?>

	</ul>
</div>

</body>
<script>
	$(".tab_change_search").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("users/search")?>";
		location.href = url;
	});
	$(".tab_change_list").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("users/list")?>";
		location.href = url;
	});

	function area_filter(area_higher_id,area_id){
		var url  = "<?=\yii\helpers\Url::toRoute("users/list")?>";
		if(area_id == 0){
			url = url + "&area_higher_id=" + area_higher_id;
		}else{
			url = url + "&area_id=" + area_id;
		}

		location.href = url;
	}
	function group_filter(medical_group_id){
		var url = "<?=\yii\helpers\Url::toRoute("users/list")?>" + "&medical_group_id=" + medical_group_id;
		location.href = url;
	}

</script>
</html>