<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/21
 * Time: 11:03
 */
?>
<style type="text/css">
	.form-control{
		width: 30%;
	}
</style>


<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>系统设置-修改密码</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>修改密码</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >

					<div class="form-group">
						<label class="col-sm-2 control-label">旧密码</label>

						<div class="col-sm-10">
							<input type="password" class="form-control old_password_data" name="old_pass" >
						</div>
					</div>
					<div class="hr-line-dashed"></div>

					<div class="form-group" id="new_pass" >
						<label class="col-sm-2 control-label" >新密码</label>

						<div class="col-sm-10">
							<input type="password" class="form-control new_password_data"  name="new_pass" >
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group" id="re_pass">
						<label class="col-sm-2 control-label" >重复密码</label>

						<div class="col-sm-10">
							<input type="password" class="form-control" name="re_pass" >
						</div>
					</div>



					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<button class="btn btn-primary" type="submit" >确定</button>
							<a href="<?=\yii\helpers\Url::toRoute("common/home")?>" class="btn btn-primary" >取消</a>
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
		validClass: "help-block m-b-none"


	});
	//以下为官方示例
	$().ready(function () {
		// validate the comment form when it is submitted
		// validate signup form on keyup and submit
		$("#signupForm").validate({
			rules: {
				old_pass: "required",
				new_pass: {
					required:true,
					notnew:true,
				},
				re_pass: {
					required:true,
					notre:true,
				},
			},
			messages: {
				old_pass: "请输入旧密码",
				new_pass: {
					required:"请输入新密码",
				},
				re_pass: {
					required:"请重新输入一次密码",
				}
			},
			submitHandler:function(){
				add_commit();
			}
		});
	});


	function add_commit(){
		var url = "<?=\yii\helpers\Url::toRoute("worker/password_save")?>";
		var data = {
			old_password    :    $(".old_password_data").val(),
			new_password    :    $(".new_password_data").val()
		};
		$.post(url,data,function(msg){
			if(msg.status){
				alert("修改成功");
				location.reload();
			}else{
				alert(msg.error);
			}
		},'json')
	}
</script>