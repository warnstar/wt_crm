<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/9
 * Time: 15:29
 */
?>

<link href="css/font-awesome.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" media="all" href="css/daterangepicker-bs3.css"/>



<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-客户详情</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>客户详情</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >
					<div class="form-group">
						<label class="col-sm-2 control-label">姓名</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">性别</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio" checked="" value="男"  name="sex">男</label>
							<label class="radio-inline"><input type="radio" value="女"  name="sex">女</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">年龄</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="age" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">手机号</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="phone" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">护照号</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="passport" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">出生日期</label>

						<div class="col-sm-10">
							<input type="text" class="form-control date"  name="birth" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">病历号(HN)</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="hn" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">所属区域</label>

						<div class="col-sm-10"  >
							<select style="width: 90px;float: left;" class="form-control m-b" name="">
								<option>请选择</option>
								<option>南区</option>
								<option>北区</option>
							</select>
							<select style="width: 90px;float: left;margin-left: 10px;" class="form-control m-b" name="area">
								<option value="0">请选择</option>
								<option>广东</option>
								<option>广西</option>
								<option>山东</option>
								<option>山西</option>

							</select>
						</div>

					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" >疗程开始时间</label>

						<div class="col-sm-10">
							<input type="text" class="form-control date"  name="star_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">疗程结束时间</label>

						<div class="col-sm-10">
							<input type="text" class="form-control date"  name="end_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">状态</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control"  name="status" >
						</div>
					</div>


					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a class="btn btn-primary" type="submit">返回</a>
							<button class="btn btn-primary" type="submit">修改</button>
							<a class="btn btn-primary" >查看当前疗程</a>
							<a class="btn btn-primary" >查看健康足迹</a>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- jQuery Validation plugin javascript-->
<script src="js/plugins/validate/jquery.validate.min.js"></script>
<script src="js/plugins/validate/messages_zh.min.js"></script>
<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/daterangepicker.js"></script>


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
				age: "required",
				phone: {
					required:true,
					phone:true
				},
				passport: {
					passport:true
				},
				birth: {
					mydate:true
				},
				area:{
					myarea:true,
				},
				star_time:{
					mydate:true,
				},
				end_time:{
					mydate:true,
				},

			},
			messages: {
				name: "请输入客户姓名",
				age: "请输入客户年龄",
				birth: {
					required: "请选择出生日期",
				},

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

</script>