<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/9
 * Time: 15:29
 */
?>
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
				<form method="post" class="form-horizontal" id="signupForm" >
					<div class="form-group">
						<label class="col-sm-2 control-label">姓名</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="account_name" >
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
						<label class="col-sm-2 control-label">手机号</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="phone" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">角色</label>

						<div class="col-sm-10"  >
							<select style="width: 120px;float: left;" class="form-control m-b" name="role_id">
								<option value="0">请选择</option>
								<option value="1">超级管理员</option>
								<option value="2">客服人员</option>
								<option value="3">医疗对接</option>
								<option value="4">品牌经理</option>
								<option value="5">市场总监</option>
								<option value="6">大区经理</option>

							</select>

						</div>

					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">品牌</label>

						<div class="col-sm-10"  >
							<select style="width: 120px;float: left;" class="form-control m-b" name="brand_id">
								<option value="0">请选择</option>
								<option value="">泰太美</option>
								<option value="">太太乐</option>
							</select>

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
							<select style="width: 90px;float: left;margin-left: 10px;" class="form-control m-b" name="area_id">
								<option value="0">请选择</option>
								<option>广东</option>
								<option>广西</option>
								<option>山东</option>
								<option>山西</option>

							</select>
						</div>

					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">微信昵称</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="wchat" >
						</div>
					</div>



					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a class="btn btn-primary" type="submit">返回</a>
							<button class="btn btn-primary" type="submit">修改</button>


						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
