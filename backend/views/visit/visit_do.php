<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/15
 * Time: 20:10
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
		<h2>回访管理-回访详情</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>回访详情</h5>
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
					<div class="form-group" style="width: 118%;">
						<div class="col-sm-4 col-sm-offset-3">
							<a href="javascript:history.go(-1)" class="btn btn-primary" type="submit">返回</a>
							<a class="btn btn-primary" >查看当前疗程</a>
							<a class="btn btn-primary" >查看健康足迹</a>
							<a href="<?=\yii\helpers\Url::toRoute("visit/visit_error")?>"  class="btn btn-primary" >处理与异常</a>
							<button class="btn btn-primary" type="submit">回访完成</button>
							<a href="<?=\yii\helpers\Url::toRoute("visit/visit_note_add")?>"  class="btn btn-primary" type="submit">添加备注</a>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>