<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/15
 * Time: 19:54
 */
?>

<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>回访管理-待回访的客户</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有待回访的客户</h5>
					<div class="ibox-tools">

					</div>
				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
							<div style="overflow: hidden;float: left;">

								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline">
										<option value="0">请选择</option>
										<option value="1">南区</option>
										<option value="2">北区</option>

									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline">
										<option value="0">请选择</option>
										<option value="1">广东</option>
										<option value="2">广西</option>

									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline">
										<option value="0">请选择</option>
										<option value="1">第十期</option>
										<option value="2">第十一期</option>
									</select>
								</div>
							</div>
							<div class="input-group">
								<input style="width: 300px;margin-left: 30px;" type="text" placeholder="请输入手机号/病历号/护照号/姓名查询" class="input-sm form-control"> <span style="float:left" class="input-group-btn">
                                        <button type="button"  class="btn btn-sm btn-primary"> 搜索</button> </span>
							</div>

						</div>

					</div>

					<div class="project-list">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>姓名</td>
								<td>护照号</td>
								<td>上次回访时间</td>
								<td>本次应回访时间</td>
								<td>状态</td>
								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">

							<tr>
								<td class="project-status">张三四</td>
								<td class="project-title">G1234567</td>
								<td class="project-title">07/03/2016</td>

								<td class="project-title">07/03/2016</td>
								<td class="project-title">疗程中</td>

								<td >
									<a href="<?=\yii\helpers\Url::toRoute("visit/visit_do")?>" class=" btn btn-white btn-sm">回访</a>

								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>