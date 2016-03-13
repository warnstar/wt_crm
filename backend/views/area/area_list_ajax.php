<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/10
 * Time: 19:33
 */
?>
<?php if($areas) foreach ($areas as $v):?>
	<tr>
		<td class="project-status"><?=$v['id']?></td>
		<td class="project-title"><?=$v['parent_name']?></td>
		<td class="project-title"><?=$v['name']?></td>
		<td ><button class="btn-delete btn btn-white btn-sm">删除</button>
		</td>
	</tr>
<?php endforeach;?>
