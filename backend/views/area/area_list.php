<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/9
 * Time: 21:26
 */
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-客户列表</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有客户</h5>
					<div class="ibox-tools">
						<a href="<?=\yii\helpers\Url::toRoute("area/add")?>" class="btn btn-primary btn-xs">添加新区域</a>
					</div>
				</div>
				<div class="ibox-content">


					<div class="project-list">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>区域编号</td>
								<td>区域名字</td>
								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">
							<?php if($area_list) foreach($area_list as $v):?>
							<tr>
								<td class="project-status"><?=$v['id']?></td>
								<td class="project-title"><?=$v['name']?></td>

								<td >
									<button class=" btn btn-white btn-sm">查看详情</button>
									<button style="display: none;" class="btn-delete btn btn-white btn-sm">删除</button>
								</td>
							</tr>

							<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
