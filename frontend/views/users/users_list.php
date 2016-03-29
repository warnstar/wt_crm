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

						if(items[1].value){
							area_filter(items[1].value);
						}else{
							area_filter(0);
						}
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
	</style>
</head>

<body>
<header class="mui-bar mui-bar-nav">
	<span class="h-xuanzhe" id="sheng">所有区域</span>
	<span class="h-xuanzhe" id='tuan'>所有出团</span>
</header>

<nav class="mui-bar mui-bar-tab">
	<a class="mui-tab-item tab_change_search" href="#">
		<span class="mui-icon mui-icon-search "></span>
		<span class="mui-tab-label">查询</span>
	</a>
	<a class="mui-tab-item mui-active tab_change_list" href="#">
		<span class="mui-icon mui-icon-bars"></span>
		<span class="mui-tab-label">所有</span>
	</a>
</nav>
<div class="mui-content">

	<ul class="mui-table-view mui-table-view-chevron">
		<li class="mui-table-view-cell">
				<span id="name" class="h-row w25">姓名</span>
				<span id="sex"  class="h-row w5">性别</span>
				<span id="sex"  class="h-row w25">所属区域</span>
				<span id="status"  class="h-row w25">疗程状态</span>

		</li>

		<?php if($users) foreach($users as $v):?>
		<li class="mui-table-view-cell">
			<a href="" class="mui-navigate-right">
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

	function area_filter(area_id){
		var url = "<?=\yii\helpers\Url::toRoute("users/list")?>" + "&area_id=" + area_id;
		location.href = url;
	}
	function group_filter(medical_group_id){
		var url = "<?=\yii\helpers\Url::toRoute("users/list")?>" + "&medical_group_id=" + medical_group_id;
		location.href = url;
	}

</script>
</html>