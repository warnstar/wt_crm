<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/17
 * Time: 19:17
 */
?>

<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-健康足迹</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有足迹</h5>
					<div class="ibox-tools">

					</div>
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
								<td>时间</td>
								<td>品牌名称</td>
								<td>护照号</td>
								<td>状态</td>
								<td>操作</td>

							</tr>
							</thead>
							<tbody align="center">
							<?php if($groups) foreach($groups as $v):?>
							<tr>
								<td class="project-status"><?=date("Y-m-d H:m:s",$v['create_time'])?></td>
								<td class="project-title"><?=$v['brand_name']?></td>
								<td class="project-title"><?=$v['user_passport']?></td>
								<td class="project-title"><?php if($v['start_time'] > time()) echo "未开始";else if($v['end_time'] < time()) echo "已结束";else echo "进行中"; ?></td>
								<td >
									<a href="<?=\yii\helpers\Url::toRoute("mgu/mgu_detail") . "&mgu_id=" . $v['id']?>" class=" btn btn-white btn-sm">查看详情</a>
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