<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/21
 * Time: 11:26
 */
?>

<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>客服问题-已处理的问题</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有记录</h5>
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
								<td>客户姓名</td>
								<td>客服名称</td>
								<td>护照号</td>
								<td>提交时间</td>
								<td>处理时间</td>
								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">
							<?php if($list) foreach($list as $v):?>
							<tr>
								<td class="project-status"><?=$v['user_name']?></td>
								<td class="project-title"><?=$v['worker_name']?></td>
								<td class="project-title"><?=$v['user_passport']?></td>
								<td class="project-title"><?=date("m/d/Y",$v['create_time'])?></td>
								<td class="project-title"><?=date("m/d/Y",$v['error_end_time'])?></td>

								<td >
									<a href="<?=\yii\helpers\Url::toRoute("visit/visit_detail") . "&id=" . $v['id'] ?>" class=" btn btn-white btn-sm">详情</a>
								</td>
							</tr>
							<?php endforeach;?>
							</tbody>

						</table>
						<div class="pages" style="width:80%;margin:0 auto;text-align: center;">
							<?=
							\yii\widgets\LinkPager::widget([
									'pagination' => $pages,
									'options' => ['class' => 'pagination pull-center', 'style' => 'margin:0px']
							]);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>