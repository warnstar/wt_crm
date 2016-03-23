<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/12
 * Time: 16:17
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
		<h2>节日管理-新建节日</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>新建节日</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >

					<div class="form-group">
						<label class="col-sm-2 control-label">节日名称</label>

						<div class="col-sm-10">
							<input type="text" class="form-control name_data" name="name" >
						</div>
					</div>
					<div class="hr-line-dashed"></div>




					<div class="form-group">
						<label class="col-sm-2 control-label" >节日时间</label>

						<div class="col-sm-10">
							<input type="text" class="form-control date time_data"  name="star_time" >
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label">节日问候语</label>

						<div class="col-sm-10">
							<textarea class="form-control greeting_data"  name="greetings" ></textarea>
						</div>

					</div>

					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<button class="btn btn-primary form_commit" type="submit">确定</button>
							<a href="<?=\yii\helpers\Url::toRoute("festival/list")?>" class="btn btn-primary" >取消</a>
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
				name: "required",
				greetings: "required",
				star_time:{
					required:true,
					mydate:true,
				},


			},
			messages: {
				name: "请输入节日名称",
				greetings: "请输入节日祝福语",

				star_time: {
					required: "请选择节日时间",
				},
			},
			submitHandler:function(){
				add_commit()
			}
		});


	});
	$(document).ready(function() {
		var mydate = new Date();
		var str = "" + (mydate.getMonth()+1) + "/";
		str += mydate.getDate() + "/";
		str += mydate.getFullYear();
		$('.date').daterangepicker({
					singleDatePicker: true,
					startDate: str,
				},
				function(start, end, label) {
				});
	});

	function add_commit(){
		var url = "<?=\yii\helpers\Url::toRoute("festival/save")?>";
		var data = {
			name    :   $(".name_data").val(),
			start_time  :   $(".time_data").val(),
			greeting    :   $(".greeting_data").val()
		};
		$.post(url,data,function(msg){
			if(msg.status){
				alert("操作成功！");
				location.href = "<?=\yii\helpers\Url::toRoute("festival/list)")?>";
			}else{
				alert(msg.error);
			}
		},'json')
	}

</script>