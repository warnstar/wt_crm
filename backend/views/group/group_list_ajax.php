<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/13
 * Time: 16:32
 */
?>
<table class="table table-hover">
	<thead>
	<tr align="center">
		<td>团编号</td>
		<td>团名称</td>
		<td>品牌</td>
		<td>出团时间</td>
		<td>回国时间</td>
		<td>出团人数</td>
		<td>操作</td>
	</tr>
	</thead>
	<tbody align="center">
	<?php if($groups) foreach($groups as $v):?>
		<tr>
			<td class="project-status"><?=$v['group_code']?></td>
			<td class="project-title"><?=$v['name']?></td>
			<td class="project-title"><?=$v['brand_name']?></td>
			<td class="project-title"><?=date("Y-m-d",$v['start_time'])?></td>
			<td class="project-title"><?=date("Y-m-d",$v['end_time'])?></td>
			<td class="project-title"><?=$v['user_count']?></td>

			<td >
				<a class=" btn btn-white btn-sm" href="<?=\yii\helpers\Url::toRoute("group/detail") . "&id=" . $v['id']?>">查看详情</a>
				<a class=" btn btn-white btn-sm" href="<?=\yii\helpers\Url::toRoute("mgu/list") . "&medical_group_id=" . $v['id']?>">查看团员</a>
				<button  value="<?=$v['id']?>" class="btn-delete btn btn-white btn-sm delete_click">删除</button>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div class="pages" style="width:80%;margin:0 auto;text-align: center;">
	<?php $pages->route = "visit/error_un_do_ajax";?>
	<?=
	\yii\widgets\LinkPager::widget([
			'pagination' => $pages,
			'options' => ['class' => 'pagination pull-center', 'style' => 'margin:0px']
	]);
	?>

</div>
