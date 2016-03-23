<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/21
 * Time: 12:13
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
		<h2>客服问题-处理客服问题</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>处理客服问题</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >
					<div class="form-group">
						<label class="col-sm-2 control-label">姓名</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control" value="<?=$detail['user_name']?>" name="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">性别</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input disabled type="radio" class="sex_data" <?=$detail['user_sex'] == 1 ? "checked" : ""?> value="1"  name="sex">男</label>
							<label class="radio-inline"><input disabled type="radio" class="sex_data" <?=$detail['user_sex'] != 1 ? "checked" : ""?> value="2"  name="sex">女</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">年龄</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control" value="<?=date("Y",time())-date("Y",$detail['user_birth'])?>"  name="age" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">手机号</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control"  value="<?=$detail['user_phone']?>"  name="phone" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">护照号</label>

						<div class="col-sm-10">
							<input disabled  type="text" class="form-control"  value="<?=$detail['user_passport']?>"  name="passport" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">出生日期</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control date"  value="<?=date("Y-m-d",$detail['user_birth'])?>"  name="birth" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">病历号(HN)</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control" value="<?=$detail['user_cases_code']?>"  name="hn" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" >所属区域</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control date" value="<?=$detail['user_area']?>"  name="star_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" >疗程开始时间</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control date"  value="<?=date("Y-m-d",$detail['start_time_mgu'])?>" name="star_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">疗程结束时间</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control date"  value="<?=date("Y-m-d",$detail['end_time_mgu'])?>" name="end_time" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">状态</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control"  value="<?=$detail['end_time_mgu'] > time() ? "疗程中" : "已结束"?>" name="status" >
						</div>
					</div>
					<div class="form-group" >
						<label class="col-sm-2 control-label">异常备注</label>

						<div class="col-sm-10">

							<textarea readonly class="form-control" id="n_1" name="n_text"><?=$detail['error_content']?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">问题提交时间</label>

						<div class="col-sm-10">
							<input disabled type="text" class="form-control date"  value="<?=date("Y-m-d",$detail['create_time'])?>"   >
						</div>
					</div>


					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a href="javascript:history.go(-1)" class="btn btn-primary" type="submit">返回</a>
							<a href="<?=\yii\helpers\Url::toRoute("mgu/mgu_detail") . "&mgu_id=" . $detail['mgu_id']?>" class="btn btn-primary" >查看当前疗程</a>
							<a href="<?=\yii\helpers\Url::toRoute("mgu/user_join_group") . "&user_id=" . $detail['user_id'] . "&brand_id=" . $detail['brand_id']?>" class="btn btn-primary" >查看健康足迹</a>
							<a class="btn btn-primary error_complete">处理完成</a>
							<a href="<?=\yii\helpers\Url::toRoute("visit/visit_note_add") . "&mgu_id=" . $detail['mgu_id'] . "&visit_id=" .  $detail['id']  . "&type=2"?>"   class="btn btn-primary" type="submit">添加备注</a>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	//回访完成
	$(".error_complete").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("visit/error_do_save")?>";
		var data = {
			visit_id      :   "<?=$detail['id']?>"
		};
		$.post(url,data,function(msg){
			if(msg.status){
				alert("处理完成！");
				location.href = "<?=\yii\helpers\Url::toRoute("visit/error_un_do")?>";
			}else{
				alert("操作失败");
			}

		},'json');
	});
</script>