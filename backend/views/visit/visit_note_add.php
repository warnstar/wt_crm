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
		<h2>用户管理-添加备注</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>添加备注</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >
					<div class="form-group">
						<label class="col-sm-2 control-label">备注项目</label>

						<div class="col-sm-10"  >
							<select style="width: auto;float: left;" class="form-control " name="type">
								<option value="0">请选择</option>
								<?php if($types) foreach($types as $v):?>
								<option value="<?=$v['id']?>"><?=$v['name']?></option>
								<?php endforeach;?>
							</select>

						</div>
					</div>
					<input type="hidden" id="leixing" value="1">
					<div class="form-group" >
						<label class="col-sm-2 control-label">类型</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio" checked="" value="1"  name="type_id">文字</label>
							<label class="radio-inline"><input type="radio" value="2"  name="type_id">图片</label>
							<label class="radio-inline"><input type="radio" value="3"  name="type_id">文件</label>
						</div>
					</div>

					<div id="bei_text" style="display:block">
						<div class="form-group" >
							<label class="col-sm-2 control-label">内容</label>

							<div class="col-sm-10">

								<textarea class="form-control" id="n_1" name="n_text"></textarea>
							</div>
						</div>

					</div>
					<div id="bei_file" style="display:none">
						<div class="form-group"  >
							<label class="col-sm-2 control-label">选择文件</label>

							<div class="col-sm-10">

								<input type="file" name="n_file" id="n_3">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>

							<div class="col-sm-10" >

							</div>
						</div>
					</div>
					<div id="bei_pic" style="display:none">
						<div class="form-group" >
							<label class="col-sm-2 control-label">选择图片</label>

							<div class="col-sm-10">

								<input type="file" name="n_pic" id="n_2" multiple class="bro_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>

							<div class="col-sm-10" id="show_img">

							</div>
						</div>

					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">

							<button class="btn btn-primary" type="submit">添加</button>
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
		validClass: "help-block m-b-none"


	});
	//以下为官方示例
	$().ready(function () {
		// validate the comment form when it is submitted
		// validate signup form on keyup and submit
		$("#signupForm").validate({
			rules: {
				n_text: {beizhu:true,},
				n_file: {beizhu:true,},
				n_pic: {beizhu:true,},


			},
			messages: {
				n_text: {beizhu:"备注内容不能空",},
				n_file: {beizhu:"请选择要上传的文件",},
				n_pic: {beizhu:"请选择要上传的图片",},

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

	$(function(){
		var formdata = new FormData();
		$(".bro_name").on("change", function(){
			var files = !!this.files ? this.files : [];
			if (!files.length || !window.FileReader) return;
			for(var i=0;i<files.length;i++){
				if (!/^image/.test( files[i].type)){
					$(".bro_name").val("");
					alert("请选择图片文件上传！");
					return;
				}
			}
			for(var i=0;i<files.length;i++){

				if (/^image/.test( files[i].type)){

					var reader = new FileReader();
					reader.readAsDataURL(files[i]);

					formdata.append("img[]", this.files[i]);

					reader.onloadend = function(){

						$('#show_img').append("<img src='" + this. result +"' />");
					}
				}

			}
		}); });
	$('input[type=radio]').click(function(event) {

		switch($(this).val()){
			case '1':$('#bei_pic').css('display', 'none');$('#bei_file').css('display', 'none');$('#bei_text').css('display', 'block');$('#leixing').val('1');break;
			case '2': $('#bei_pic').css('display', 'block');$('#bei_file').css('display', 'none');$('#bei_text').css('display', 'none');$('#leixing').val('2');break;
			case '3': $('#bei_file').css('display', 'block');$('#bei_pic').css('display', 'none');$('#bei_text').css('display', 'none');$('#leixing').val('3');break;
		}
	});
</script>