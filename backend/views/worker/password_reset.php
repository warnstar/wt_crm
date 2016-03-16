<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/13
 * Time: 14:48
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
		<h2>系统设置-修改密码</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>修改密码</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >

					<div class="form-group">
						<label class="col-sm-2 control-label">旧密码</label>

						<div class="col-sm-10">
							<input type="password" class="form-control" name="old_pass" >
						</div>
					</div>
					<div class="hr-line-dashed"></div>

					<div class="form-group" id="new_pass" >
						<label class="col-sm-2 control-label" >新密码</label>

						<div class="col-sm-10">
							<input type="password" class="form-control"  name="new_pass" >
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group" id="re_pass">
						<label class="col-sm-2 control-label" >重复密码</label>

						<div class="col-sm-10">
							<input type="password" class="form-control" name="re_pass" >
						</div>
					</div>



					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<button class="btn btn-primary" type="submit">确定</button>
							<a class="btn btn-primary" >取消</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
