<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/12
 * Time: 21:33
 */
?>
<table class="table table-hover">
	<thead>
	<tr align="center">
		<td>姓名</td>
		<td>性别</td>
		<td>年龄</td>
		<td>护照号</td>
		<td>品牌</td>
		<td>状态</td>
		<td>操作</td>
	</tr>
	</thead>
	<tbody align="center">
	<?php if($users) foreach($users as $v):?>
		<tr>
			<td class="project-status"><?=$v['name']?></td>
			<td class="project-title"><?=$v['sex'] == 1 ? '男' : '女'?></td>
			<td class="project-title"><?=date('Y',time())-date('Y',$v['birth'])?></td>
			<td class="project-title"><?=$v['passport']?></td>
			<td class="project-title"><?=$v['brand_name']?></td>
			<td class="project-title"><?php if(!$v['last_mgu']) echo "无疗程";else echo  ($v['end_time_mgu'] - $v['start_time_mgu'] > 0) ? "疗程中" : "疗程结束";?></td>
			<td >
				<a href="<?=\yii\helpers\Url::toRoute("users/detail") . "&id=" . $v['id']?>" class=" btn btn-white btn-sm">查看详情</a>
				<button class="btn-delete btn btn-white btn-sm">删除</button>
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
