<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/13
 * Time: 14:46
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
		<h2>出团管理-医疗团详情</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>医疗团详情</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >
					<input type="hidden" class="id_data" value="<?=$group['id']?>">
					<div class="form-group">
						<label class="col-sm-2 control-label">团编号</label>

						<div class="col-sm-10">
							<input type="text" class="form-control code_data" value="<?=$group['group_code']?>" disabled name="group_code" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">团名称</label>

						<div class="col-sm-10">
							<input type="text" class="form-control name_data" value="<?=$group['name']?>"  name="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">品牌</label>

						<div class="col-sm-10"  >
							<select disabled="disabled" style="width: 90px;float: left;" class="form-control m-b brand_data" name="brand_id">
								<option value="0">请选择</option>
								<?php if($brands) foreach($brands as $v):?>
									<option <?=$group['brand_id'] == $v['id'] ? 'selected=true' : ''?> value="<?=$v['id']?>"><?=$v['name']?></option>
								<?php endforeach;?>
							</select>
						</div>

					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" >出团时间</label>

						<div class="col-sm-10">
							<input disabled="disabled" type="text" class="form-control date start_time" value="<?=date("m/d/Y",$group['start_time'])?>" name="star_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">回国时间</label>

						<div class="col-sm-10">
							<input disabled="disabled" type="text" class="form-control date end_time" value="<?=date("m/d/Y",$group['end_time'])?>" name="end_time" >
						</div>
					</div>

					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a href="javascript:history.go(-1)" class="btn btn-primary" type="submit">返回</a>
							<button class="btn btn-primary" type="submit">修改</button>
							<a class="btn btn-primary" href="<?=\yii\helpers\Url::toRoute("mgu/list") . "&medical_group_id=" . $group['id']?>"">查看团员</a>
							<a class="btn btn-primary" href="<?=\yii\helpers\Url::toRoute("mgu/add") . "&medical_group_id=" . $group['id']?>">添加团员</a>
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
				brand_id:{
					notling:true,
				},
				star_time:{
					required:true,
					mydate:true,
				},
				end_time:{
					required:true,
					mydate:true,
				}

			},
			messages: {
				name: "请输入团名称",
				brand_id:{
					noling:"请选择品牌",
				},
				star_time:{
					required:"请选择出团时间",
				},
				end_time:{
					required:"请选择回国时间",

				}
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
		var url = "<?=\yii\helpers\Url::toRoute("group/save")?>";
		var data = {
			id          :   $(".id_data").val(),
			group_code  :   $(".code_data").val(),
			name        :   $(".name_data").val(),
			brand_id    :   $(".brand_data").val(),
			start_time  :   $(".start_time").val(),
			end_time    :   $(".end_time").val()
		};

		$.post(url,data,function(msg){
			if(msg.status){
				alert("操作成功！");
				location.href = "<?=\yii\helpers\Url::toRoute("group/list")?>";
			}else{
				alert(msg.error);
			}
		},'json')
	}
</script>