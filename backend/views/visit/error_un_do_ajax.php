<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/21
 * Time: 16:04
 */
?>

<table class="table table-hover">
	<thead>
	<tr align="center">
		<td>客户姓名</td>
		<td>客服名称</td>
		<td>护照号</td>
		<td>提交时间</td>
		<td>备注</td>
		<td>操作</td>
	</tr>
	</thead>
	<tbody align="center">
	<?php if($list) foreach($list as $v ):?>
		<tr>
			<td class="project-status"><?=$v['user_name']?></td>
			<td class="project-title"><?=$v['worker_name']?></td>
			<td class="project-title"><?=$v['user_passport']?></td>
			<td class="project-title"><?=date("m/d/Y",$v['create_time'])?></td>
			<td class="project-title"><?=$v['error_content']?></td>

			<td >
				<a href="<?=\yii\helpers\Url::toRoute("visit/error_do") . "&visit_id=" . $v['id']?>" class=" btn btn-white btn-sm">处理</a>
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