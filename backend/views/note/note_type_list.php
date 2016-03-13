<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/12
 * Time: 18:54
 */
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>备注设置-所有备注</h2>
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
						<a href="<?=\yii\helpers\Url::toRoute("note/note_type_add")?>" class="btn btn-primary btn-xs">创建备注项</a>
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
								<td>备注名称</td>
								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">
							<?php if($note_types) foreach($note_types as $v):?>
							<tr>
								<td class="project-status"><?=$v['name']?></td>
								<td >
									<a class=" btn btn-white btn-sm" href="<?=\yii\helpers\Url::toRoute("note/note_type_detail") . "&id=" . $v['id']?>">编辑</a>
									<button class="btn-delete btn btn-white btn-sm">删除</button>
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
