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
</style>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-回访异常</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>回访异常</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >
					<div class="form-group">
						<label class="col-sm-2 control-label">备注名称</label>

						<div class="col-sm-10">
							<input type="text" class="form-control" disabled value='异常备注' name="group_code" >
						</div>
					</div>
					<div class="form-group" >
						<label class="col-sm-2 control-label">内容</label>

						<div class="col-sm-10">

							<textarea class="form-control" id="n_1" name="n_text"></textarea>
						</div>
					</div>
					<div class="form-group" >
						<label class="col-sm-2 control-label">通知</label>

						<div class="col-sm-10">
							<label class="checkbox-inline">
								<input type="checkbox" value="option3" checked id="inlineCheckbox3">医疗对接人员</label>
							<label class="checkbox-inline">
								<input type="checkbox" value="option1" id="inlineCheckbox1">大区经理</label>
							<label class="checkbox-inline">
								<input type="checkbox" value="option2" id="inlineCheckbox2">市场总监</label>
							<label class="checkbox-inline">
								<input type="checkbox" value="option3" id="inlineCheckbox3">品牌经理</label>
						</div>

					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">明天通知我</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input type="radio"  value="yes"  name="">是</label>
							<label class="radio-inline"><input type="radio" checked value="no"  name="">否</label>
						</div>
					</div>



					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">

							<button class="btn btn-primary" type="submit">确定</button>
							<a href="javascript:history.go(-1)" class="btn btn-primary" >取消</a>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>