<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/17
 * Time: 15:41
 */
?>
<script src="js/plugins/fancybox/jquery.fancybox.js"></script>
<link href="js/plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
<style type="text/css">
	.form-control{
		width: 30%;
	}
	.beizhu_p{
		width: 30%;
		word-break:break-all;
	}
	.beizhu_p{
		width: 30%;
		word-break:break-all;
	}
	.beizhu_img{
		width: 100px !important;
		height: auto !important;
	}
	.beizhu_wenjian{
		line-height: 35px;
	}
</style>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-查看疗程</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>疗程详情</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >
					<div class="form-group">
						<label class="col-sm-2 control-label">姓名</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control" value="<?=$mgu_detail['name']?>" name="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">性别</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input disabled type="radio" class="sex_data" checked="<?=$mgu_detail['sex'] == 1 ? true : false?>" value="1"  name="sex">男</label>
							<label class="radio-inline"><input disabled type="radio" class="sex_data" checked="<?=$mgu_detail['sex'] == 1 ? true : false?>" value="2"  name="sex">女</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">年龄</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control" value="<?=date("Y",time())-date("Y",$mgu_detail['birth'])?>"  name="age" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">手机号</label>

						<div class="col-sm-10">
							<input disabled  type="text" class="form-control" value="<?=$mgu_detail['phone']?>"  name="phone" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">团名称</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control"  value="<?=$mgu_detail['group_name']?>"  name="passport" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">病历号(HN)</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control" value="<?=$mgu_detail['cases_code']?>"  name="hn" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" >疗程开始时间</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control date"  value="<?=date("m/d/Y",$mgu_detail['start_time'])?>"   name="star_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">疗程结束时间</label>

						<div class="col-sm-10">
							<input type="text" class="form-control date end_time"  value="<?=date("m/d/Y",$mgu_detail['end_time'])?>"  name="end_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">见诊专家</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control"  name="status" >
						</div>
					</div>


					<?php if($visit_notes) foreach($visit_notes as $v):?>
						<?php if($v['content_type'] == 1):?>
							<div class="form-group">
								<label class="col-sm-2 control-label">备注内容为文字</label>

								<div class="col-sm-10">
									<p class="beizhu_p"><?=$v['content']?></p>
									<p>备注人：<span><?=$v['worker_name']?>（<?=$v['worker_role']?>）</span>&nbsp;&nbsp;&nbsp;备注时间：<span><?=date("Y-m-d H:m:s",$v['create_time'])?></span></p>
								</div>
							</div>
						<?php endif;?>

						<?php if($v['content_type'] == 3):?>
							<div class="form-group">
								<label class="col-sm-2 control-label">备注内容为文件</label>
								<div class="col-sm-10">
									<?php $content = json_decode($v['content']);?>

									<?php if($content) foreach($content as $file):?>
										<p class="beizhu_wenjian">  <a href="<?=isset($file->url) ? $file->url : ""?>"><?=isset($file->name) ? $file->name : "文件"?></a></p>
									<?php endforeach;?>

									<p>备注人：<span><?=$v['worker_name']?>（<?=$v['worker_role']?>）</span>&nbsp;&nbsp;&nbsp;备注时间：<span><?=date("Y-m-d H:m:s",$v['create_time'])?></span></p>
								</div>
							</div>
						<?php endif;?>

						<?php if($v['content_type'] == 2):?>
							<div class="form-group">
								<label class="col-sm-2 control-label">备注图片</label>

								<div class="col-sm-10">
									<div>
										<?php $content = json_decode($v['content']);?>

										<?php if($content) foreach($content as $img):?>
											<a class="fancybox" href="<?=isset($img->url) ? $img->url : ""?>" title="图片3">
												<img class="beizhu_img" alt="image" src="<?=isset($img->url_object) ? (\common\lib\oss\Oss::IMG_OPTION_ADDR . urlencode($img->url_object) . "@100w") : ""?>" />
											</a>
										<?php endforeach;?>
										<p>备注人：<span><?=$v['worker_name']?>（<?=$v['worker_role']?>）</span>&nbsp;&nbsp;&nbsp;备注时间：<span><?=date("Y-m-d H:m:s",$v['create_time'])?></span></p>
									</div>
								</div>
							</div>
						<?php endif;?>
					<?php endforeach;?>


					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">

							<a href="javascript:history.go(-1)" class="btn btn-primary" >返回</a>
							<button class="btn btn-primary" >保存</button>
							<a href="<?=\yii\helpers\Url::toRoute("visit/visit_list") . "&mgu_id=" . $mgu_detail['id']?>" class="btn btn-primary" >查看回访记录</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('.fancybox').fancybox({
			openEffect: 'none',
			closeEffect: 'none',
			centerOnScroll:false,
		});
	});

</script>



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
				end_time:{
					mydate:true
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
		var url = "<?=\yii\helpers\Url::toRoute("mgu/mgu_update_save")?>";
		var data = {
			mgu_id      :   "<?=$mgu_detail['id']?>",
			end_time    :   $(".end_time").val()
		};
		$.post(url,data,function(msg){
			if(msg.status){
				alert("更新成功");
				history.go(-1);
			}else{
				alert(msg.error);
			}
		},'json');
	}
</script>