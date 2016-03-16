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
								<option value="1">账单</option>
								<option value="2">清单</option>
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