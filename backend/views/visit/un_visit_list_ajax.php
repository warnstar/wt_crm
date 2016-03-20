<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/20
 * Time: 14:52
 */
?>
<table class="table table-hover">
	<thead>
	<tr align="center">
		<td>姓名</td>
		<td>护照号</td>
		<td>上次回访时间</td>
		<td>本次应回访时间</td>
		<td>操作</td>
	</tr>
	</thead>
	<tbody align="center">
	<?php if($mgu) foreach($mgu as $v):?>
		<tr>
			<td class="project-status"><?=$v['user_name']?></td>
			<td class="project-title"><?=$v['user_passport']?></td>
			<td class="project-title"><?=$v['last_visit'] ? date("Y-m-d",$v['last_visit']) : "无"?></td>
			<td class="project-title"><?=date("Y-m-d",$v['next_visit'])?></td>


			<td >
				<a href="<?=\yii\helpers\Url::toRoute("visit/visit_do") . "&id=" .  $v['id']?>" class=" btn btn-white btn-sm">回访</a>

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
