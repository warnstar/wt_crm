<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/9
 * Time: 15:29
 */
?>
<style type="text/css">
	.form-control{
		width: 30%;
	}
</style>
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
					<input type="hidden" class="id_data" value="<?=$user['id']?>">
					<div class="form-group">
						<label class="col-sm-2 control-label">姓名</label>

						<div class="col-sm-10">
							<input type="text" class="form-control name_data" value="<?=$user['name']?>"  name="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">性别</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio" class="sex_data" <?=$user['sex'] == 1 ? "checked" : ""?> value="1"  name="sex">男</label>
							<label class="radio-inline"><input type="radio" class="sex_data" <?=$user['sex'] != 1 ? "checked" : ""?> value="2"  name="sex">女</label>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">手机号</label>

						<div class="col-sm-10">
							<input type="text" class="form-control phone_data" value="<?=$user['phone']?>"  name="phone" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">护照号</label>

						<div class="col-sm-10">
							<input type="text" class="form-control passport_data" value="<?=$user['passport']?>"  name="passport" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">出生日期</label>

						<div class="col-sm-10">
							<input type="text" class="form-control date birth_data" value="<?=date("m/d/Y",$user['birth'])?>"  name="birth" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">病历号(HN)</label>

						<div class="col-sm-10">
							<input type="text" class="form-control cases_data" value="<?=$user['cases_code']?>"  name="hn" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">品牌</label>

						<select style="width: 90px;float: left;" class="form-control m-b brand_data" name="brand">
							<option value="0">品牌</option>
							<?php if(isset($brands) && $brands) foreach($brands as $v):?>
								<option <?php if($user['brand_id'] == $v['id']) echo "selected=selected";?> value="<?=$v['id']?>"><?=$v['name']?></option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">所属区域</label>

						<div class="col-sm-10"  >
							<select style="width: 90px;float: left;" class="form-control m-b area_data" name="">
								<option value="0">请选择</option>
								<?php if($area_higher) foreach ($area_higher as $higher):?>
									<option <?=$higher['id'] == $user['area_higher_id'] ? 'selected=true' : ''?>  value="<?=$higher['id']?>"><?=$higher['name']?></option>
								<?php endforeach;?>
							</select>
							<select style="width: 90px;float: left;margin-left: 10px;" class="form-control m-b area_lower_data" name="area_id">
								<?php if($area_lower) foreach ($area_lower as $lower):?>
									<option <?=$lower['id'] == $user['area_id'] ? 'selected=true' : ''?>  value="<?=$lower['id']?>"><?=$lower['name']?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" >疗程开始时间</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control date" value="<?=date("m/d/Y",$user['start_time_mgu'])?>"  name="star_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">疗程结束时间</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control date" value="<?=date("m/d/Y",$user['end_time_mgu'])?>"  name="end_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">状态</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control"
					        value="<?php
							if($user['end_time_mgu'] < time())
								echo "已结束";
							else if($user['start_time_mgu'] > time())
								echo "未开始";
							else echo "进行中";
							?>"   name="status" >
						</div>
					</div>


					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a href="<?=\yii\helpers\Url::toRoute("users/list")?>" class="btn btn-primary" type="submit">返回</a>
							<button class="btn btn-primary form_commit">修改</button>
							<?php if($user['last_mgu']):?>
							<a href="<?=\yii\helpers\Url::toRoute("mgu/mgu_detail") . "&mgu_id=" . $user['last_mgu']?>" class="btn btn-primary" >查看当前疗程</a>
							<?php endif;?>
							<a <a href="<?=\yii\helpers\Url::toRoute("mgu/user_join_group") . "&user_id=" . $user['id']?>" class="btn btn-primary" >查看健康足迹</a>
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
				brand: {
					required:true
				},
				area:{
					myarea:true,
				}
			},
			messages: {
				name: "请输入客户姓名",
				age: "请输入客户年龄",
				birth: {
					required: "请选择出生日期",
				},

			},
			submitHandler:function(){
				add_commit()
			}
		});


	});
	$(document).ready(function() {
		var mydate = new Date('01/01/1980');
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


	//联动变化次级区域
	$("body").on("change",".area_data",function(){
		var area_id = $(this).val();
		var url = "<?=\yii\helpers\Url::toRoute("area/area_select")?>";
		var data = {
			id          :   area_id
		};
		if(data.id != 0){
			$.get(url,data,function(msg){
				$(".area_lower_data").val(0);
				$(".area_lower_data").empty();
				$(".area_lower_data").html(msg);
			})
		}else{
			$(".area_lower_data").val(0);
			$(".area_lower_data").empty();
		}
	});

	function add_commit(){
		var url = "<?=\yii\helpers\Url::toRoute("users/save")?>";
		var data = {
			id          :   $(".id_data").val(),
			name        :   $(".name_data").val(),
			sex         :   $(".sex_data:checked").val(),
			phone       :   $(".phone_data").val(),
			passport    :   $(".passport_data").val(),
			birth       :      $(".birth_data").val(),
			cases_code  :   $(".cases_data").val(),
			brand_id    :   $(".brand_data").val(),
			area_id     :   $(".area_lower_data").val(),
		};

		console.log(data);
		$.post(url,data,function(msg){
			if(msg.status){
				alert("操作成功！");
				location.href = "<?=\yii\helpers\Url::toRoute("users/list")?>";
			}else{
				alert(msg.error);
			}
		},'json')
	}
</script>