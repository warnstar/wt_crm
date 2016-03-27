<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/10
 * Time: 20:53
 */
?>
<table class="table table-hover">
	<thead>
	<tr align="center">
		<td>姓名</td>
		<td>性别</td>
		<td>角色</td>
		<td>品牌</td>
		<td>区域</td>
		<td>微信昵称</td>
		<td>操作</td>
	</tr>
	</thead>

	<tbody align="center">
	<?php foreach($workers as $v):?>
		<tr>
			<td class="project-status"><?=$v['name']?></td>
			<td class="project-title"><?=$v['sex'] == 1 ? "男":"女"?></td>
			<td class="project-title"><?=$v['role_name']?></td>
			<td class="project-title"><?=$v['brand_name']?></td>
			<td class="project-title"><?=$v['area_name']?></td>
			<td class="project-title"><?=$v['wchat']?></td>

			<td >
				<a href="<?=\yii\helpers\Url::toRoute("worker/detail") . "&id=" . $v['id']?>" class=" btn btn-white btn-sm">查看详情</a>
				<button value="<?=$v['id']?>" class="btn-delete btn btn-white btn-sm delete_click">删除</button>
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