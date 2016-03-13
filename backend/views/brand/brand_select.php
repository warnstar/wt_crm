<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/11
 * Time: 11:52
 */
?>
<option value="0">请选择</option>
<?php if($brands) foreach($brands as $b):?>
	<option value="<?=$b['id']?>"><?=$b['name']?></option>
<?php endforeach;?>
