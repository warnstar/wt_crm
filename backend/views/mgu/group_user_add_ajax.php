<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/21
 * Time: 16:50
 */
?>
<table class="table table-hover">
	<thead>
	<tr >
		<th>姓名</th>
		<th>性别</th>
		<th>年龄</th>
		<th>护照号</th>
		<th>操作</th>
	</tr>
	</thead>
	<tbody>
	<?php if($users) foreach($users as $v):?>
		<tr>
			<td class="project-status"><?=$v['name']?></td>
			<td class="project-title"><?=$v['sex'] == 1 ? '男' : '女'?></td>
			<td class="project-title"><?=date('Y',time())-date('Y',$v['birth'])?></td>
			<td class="project-title"><?=$v['passport']?></td>

			<td >
				<button class=" btn btn-white btn-sm add handle add_click" group_id="<?=$group_id?>" user_id="<?=$v['id']?>"  data-id='3' >添加</button>
			</td>
		</tr>
	<?php endforeach;?>

	</tbody>
</table>
<div class="pages" style="width:80%;margin:0 auto;text-align: center;">
	<?php $pages->route = "mgu/add_ajax";?>
	<?=
	\yii\widgets\LinkPager::widget([
		'pagination' => $pages,
		'options' => ['class' => 'pagination pull-center', 'style' => 'margin:0px']
	]);
	?>
</div>
