<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/15
 * Time: 20:18
 */
?>
<style type="text/css">
	.form-control{
		width: 30%;
	}
	textarea{
		border: 1px solid #e5e6e7;
		font-size: 14px;
		width: 30%;
		height: 70px;
	}
	#show_img img{
		max-height: 100px;
	}
</style>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-回访异常</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>回访异常</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >
					<div class="form-group">
						<label class="col-sm-2 control-label">备注名称</label>

						<div class="col-sm-10">
							<input type="text" class="form-control" disabled value='异常备注' name="group_code" >
						</div>
					</div>
					<div class="form-group" >
						<label class="col-sm-2 control-label">内容</label>

						<div class="col-sm-10">

							<textarea class="form-control content_data" id="n_1" name="n_text"></textarea>
						</div>
					</div>
					<div class="form-group" >
						<label class="col-sm-2 control-label">通知</label>

						<div class="col-sm-10">
							<label class="checkbox-inline">
								<input type="checkbox" class="notify_user" value="3" id="inlineCheckbox3">医疗对接人员</label>
							<label class="checkbox-inline">
								<input type="checkbox" class="notify_user" value="6" id="inlineCheckbox1">大区经理</label>
							<label class="checkbox-inline">
								<input type="checkbox" class="notify_user" value="5" id="inlineCheckbox2">市场总监</label>
							<label class="checkbox-inline">
								<input type="checkbox" class="notify_user" value="4" id="inlineCheckbox3">品牌经理</label>
						</div>

					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">明天通知我</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio" class="next_day"  value="1"  name="notify">是</label>
							<label class="radio-inline"><input type="radio" class="next_day" checked value="0"  name="notify">否</label>
						</div>
					</div>

					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">

							<button class="btn btn-primary" type="submit">确定</button>
							<a href="javascript:history.go(-1)" class="btn btn-primary" >取消</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	//以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
	//以下是数据验证
	$.validator.setDefaults({
		highlight: function (element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function (element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
		},
		errorElement: "span",
		errorClass: "help-block m-b-none",
		validClass: "help-block m-b-none"});
	//以下为官方示例
	$().ready(function () {
		// validate the comment form when it is submitted
		// validate signup form on keyup and submit
		$("#signupForm").validate({
			rules: {
				n_text: 'required'
			},
			messages: {
				n_text:'备注内容不能为空'
			},
			submitHandler:function(){
				add_commit()
			}
		});
	});

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
			next_day        :   $(".next_day:checked").val(),
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