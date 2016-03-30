<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>回访异常</title>

	<script src="js/mui.min.js"></script>
	<script src="js/mui.picker.js"></script>
	<script src="js/mui.poppicker.js"></script>
	<link href="css/mui.min.css" rel="stylesheet" />
	<link href="css/mui.picker.css" rel="stylesheet" />
	<link href="css/mui.poppicker.css" rel="stylesheet" />

	<script src="js/jquery-2.2.2.min.js"></script>

	<script type="text/javascript" charset="UTF-8">
		(function($, doc) {
			$.init();
		})(mui, document);
	</script>
	<style>
		.mui-page-content {
			margin-top: 20px;
		}
		a.h-btn{
			margin-left: 30px;
		}
		.h-div{
			text-align: center;
			margin-top: 20px;
		}
	</style>
</head>

<body>
<div class="mui-content">

	<div class="mui-page-content">
		<form action="" method="post">

			<p>异常备注：</p>
			<div class="row mui-input-row">
				<textarea id='question' class="mui-input-clear question content_data" placeholder="请详细描述你遇到的问题..."></textarea>
			</div>
			<p>通知</p>
			<ul class="mui-table-view">
				<li class="mui-table-view-cell mui-checkbox mui-left">
					<input name="checkbox" type="checkbox" class="notify_user" value="3">医疗对接人员
				</li>
				<li class="mui-table-view-cell mui-checkbox mui-left">
					<input name="checkbox" type="checkbox" class="notify_user" value="6">大区经理
				</li>
				<li class="mui-table-view-cell mui-checkbox mui-left">
					<input name="checkbox" type="checkbox" class="notify_user" value="5">市场总监
				</li>
				<li class="mui-table-view-cell mui-checkbox mui-left">
					<input name="checkbox" type="checkbox" class="notify_user" value="4">品牌经理
				</li>
				<li class="mui-table-view-cell">
					明天通知我
					<div id="next_day" class="mui-switch">
						<div class="mui-switch-handle"></div>
					</div>
				</li>
			</ul>
			<div class="h-div">
				<a  type="button" class="h-btn mui-btn mui-btn-green commit_click">提交</a>
				<a href="javascript:history.go(-1)"  type="button" class="h-btn mui-btn mui-btn-red">取消</a>
			</div>
		</form>

	</div>

</div>
</body>
<script type="text/javascript">

	//提交
	$(".commit_click").click(function(){

		if(!$(".content_data").val()){
			alert("备注内容不能为空！");
		}else{
			add_commit();
		}
	});

	function get_next_day(){
		var next_day = 0;
		var isActive = document.getElementById("next_day").classList.contains("mui-active");

		if(isActive){
			next_day = 1;
		}

		return next_day;
	}


	function get_notify_user(){
		var content = '';

		$('.notify_user').each(function(){
			if($(this).prop('checked')){
				content += (content ? ',' : '') + $(this).val();
			}
		});

		return content;
	}

	function add_commit(){
		var url = "<?=\yii\helpers\Url::toRoute("visit/visit_error_save")?>";

		var notify_user = get_notify_user();
		var data = {
			mgu_id          :   "<?=$mgu_id?>",
			content         :   $(".content_data").val(),
			next_day        :   get_next_day(),
			notify_user     :   notify_user
		};
		
		$.post(url,data,function(msg){

			if(msg.status){
				alert("创建异常备注成功");
				location.href = "<?=\yii\helpers\Url::toRoute("visit/un_visit_list")?>";
			}else{
				alert(msg.error);
			}
		},'json');
	}
</script>

</html>