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
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-职员详情</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>职员详情</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal form_data" id="signupForm" >
					<input type="hidden" value="<?=$worker['id']?>" class="id_data">
					<div class="form-group">
						<label class="col-sm-2 control-label">姓名</label>

						<div class="col-sm-10">
							<input type="text" class="form-control name_data" value="<?=$worker['name']?>"  name="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">性别</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio" class="sex_data" <?=$worker['sex'] == 1 ? "checked" : ""?> value="1"  name="sex">男</label>
							<label class="radio-inline"><input type="radio" class="sex_data" <?=$worker['sex'] != 1 ? "checked" : ""?> value="2"  name="sex">女</label></div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">手机号</label>

						<div class="col-sm-10">
							<input type="text" class="form-control phone_data" value="<?=$worker['phone']?>" name="phone" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">密码</label>

						<div class="col-sm-10">
							<input type="password" class="form-control password_data" name="password" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">角色</label>

						<div class="col-sm-10"  >
							<select style="width: 120px;float: left;" class="form-control m-b role_data" name="role_id">
								<option value="0">请选择</option>
								<?php if($roles) foreach ($roles as $role):?>
								<option <?=$role['id'] == $worker['role_id'] ? 'selected=true' : ''?> value="<?=$role['id']?>"><?=$role['name']?></option>
								<?php endforeach;?>
							</select>

						</div>

					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">品牌</label>

						<div class="col-sm-10"  >
							<select style="width: 120px;float: left;" class="form-control m-b brand_data" name="brand_id">
								<option value="0">请选择</option>
								<?php if($brands) foreach ($brands as $brand):?>
									<option <?=$brand['id'] == $worker['brand_id'] ? 'selected=true' : ''?>  value="<?=$brand['id']?>"><?=$brand['name']?></option>
								<?php endforeach;?>
							</select>

						</div>

					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">所属区域</label>

						<div class="col-sm-10"  >
							<select style="width: 90px;float: left;" class="form-control m-b area_data" name="">
								<option value="0">请选择</option>
								<?php if($area_higher) foreach ($area_higher as $higher):?>
									<option <?=$higher['id'] == $worker['area_higher_id'] ? 'selected=true' : ''?>  value="<?=$higher['id']?>"><?=$higher['name']?></option>
								<?php endforeach;?>
							</select>
							<select style="width: 90px;float: left;margin-left: 10px;" class="form-control m-b area_lower_data" name="area_id">
								<?php if($area_lower) foreach ($area_lower as $lower):?>
									<option <?=$lower['id'] == $worker['area_id'] ? 'selected=true' : ''?>  value="<?=$lower['id']?>"><?=$lower['name']?></option>
								<?php endforeach;?>
							</select>
						</div>

					</div>
					<div hidden class="form-group">
						<label  class="col-sm-2 control-label">微信昵称</label>

						<div class="col-sm-10">
							<input type="text" class="form-control wchat_data"  name="wchat" >
						</div>
					</div>



					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a href="javascript:history.go(-1)" class="btn btn-primary">返回</a>
							<input type="submit" class="btn btn-primary submit">

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

		$(".form_data").validate({
			rules: {
				name: "required",
				phone: {
					required:true,
					phone:true
				},
				brand_id: {
					notling:true
				},
				area_id:{
					myarea:true,
				},
			},
			messages: {
				name: "请输入客户姓名",
				age: "请输入客户年龄",
				role_id: {
					notling:"请选择一个角色",
				},
				brand_id: {
					notling:"请选择一个品牌",
				}
			},
			submitHandler:function(){
				add_commit()
			}

		});
	});
	//角色变化---》品牌变化
	$("body").on("change",".role_data",function(){
		var url = "<?=\yii\helpers\Url::toRoute("brand/brand_select")?>";
		var role_id = $(this).val();
		var data = {
			role_id  :   role_id
		};
		$.get(url,data,function(msg){
			$(".brand_data").val(0);
			$(".brand_data").empty();
			$(".brand_data").html(msg);
		})
	});

	//角色--》品牌---》区域
	$("body").on("change",".brand_data",function(){
		var area_id = $(this).val();
		var url = "<?=\yii\helpers\Url::toRoute("area/area_select_role_brand")?>";
		var data = {
			role_id     :   $(".role_data").val(),
			brand_id    :   $(".brand_data").val()
		};

		$.get(url,data,function(msg){
			$(".area_data").val(0);
			$(".area_data").empty();
			$(".area_data").html(msg);
		})

	});
	//联动变化次级区域
	$("body").on("change",".area_data",function(){
		var area_id = $(this).val();
		var url = "<?=\yii\helpers\Url::toRoute("area/area_select_role_brand")?>";
		var data = {
			id          :   area_id,
			role_id     :   $(".role_data").val(),
			brand_id    :   $(".brand_data").val()
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
		var url = "<?=\yii\helpers\Url::toRoute("worker/save")?>";
		var data = {
			id      :   $(".id_data").val(),
			name    :   $(".name_data").val(),
			sex     :   $(".sex_data:checked").val(),
			phone   :   $(".phone_data").val(),
			role_id :   $(".role_data").val(),
			brand_id:   $(".brand_data").val(),
			area_id :   $(".area_lower_data").val(),
			password   :   $(".password_data").val()
		};

		$.post(url,data,function(msg){
			if(msg.status){
				alert("操作成功！");
				location.href = "<?=\yii\helpers\Url::toRoute("worker/list")?>";
			}else{
				alert(msg.error);
			}
		},'json')
	}
</script>
