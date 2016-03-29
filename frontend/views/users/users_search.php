<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>查询</title>
	<script src="js/mui.min.js"></script>
	<link href="css/mui.min.css" rel="stylesheet" />
	<script type="text/javascript" charset="UTF-8">
		mui.init();
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
		#login-form{
			margin-top: 30%;
		}
		#login{
			margin-top: 30px;
			width: 80%;
			margin-left: auto;
			margin-right: auto;
			padding: 10px;
		}
	</style>
</head>

<body>

<nav class="mui-bar mui-bar-tab">
	<a class="mui-tab-item mui-active tab_change_search" href="#">
		<span class="mui-icon mui-icon-search "></span>
		<span class="mui-tab-label">查询</span>
	</a>
	<a class="mui-tab-item tab_change_list" href="#">
		<span class="mui-icon mui-icon-bars"></span>
		<span class="mui-tab-label">所有</span>
	</a>
</nav>
<div class="mui-content">
	<form id='login-form' class="mui-input-group">
		<div class="mui-input-row">
			<input id='account' type="text" class="mui-input-clear mui-input search_data" placeholder="请输入客户姓名、护照号、手机号查询">
		</div>
	</form>
	<a id='login' href="#" class="mui-btn mui-btn-block mui-btn-primary search_click">搜索</a>
</div>
</body>
<script src="js/jquery-2.2.2.min.js"></script>
<script>
	$(".tab_change_search").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("users/search")?>";
		location.href = url;
	});
	$(".tab_change_list").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("users/list")?>";
		location.href = url;
	});

	$(".search_click").click(function(){
		var search_data = $(".search_data").val();
		if(search_data){
			var url = "<?=\yii\helpers\Url::toRoute("users/list")?>"  + "&search=" + search_data;
			location.href = url;
		}
	});
</script>
</html>