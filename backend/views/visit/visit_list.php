<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/15
 * Time: 19:50
 */
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>回访管理-回访列表</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有记录</h5>

				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>



						</div>

					</div>

					<div class="project-list">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>回访时间</td>
								<td>客户名称</td>
								<td>品牌名称</td>
								<td>回访状态</td>
								<td>经办人</td>

								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">
							<tr>
								<td class="project-status">05/04/2015 15:15:15</td>
								<td class="project-title">张三</td>
								<td class="project-title">泰太美</td>
								<td class="project-title">正常</td>
								<td class="project-title">李四</td>
								<td >
									<a class=" btn btn-white btn-sm">查看详情</a>
									<button class="btn-delete btn btn-white btn-sm">删除</button>
								</td>
							</tr>
							<tr>
								<td class="project-status">05/04/2015 15:15:15</td>
								<td class="project-title">张三</td>
								<td class="project-title">泰太美</td>
								<td class="project-title">正常</td>
								<td class="project-title">李四</td>
								<td >
									<a class=" btn btn-white btn-sm">查看详情</a>
									<button class="btn-delete btn btn-white btn-sm">删除</button>
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
