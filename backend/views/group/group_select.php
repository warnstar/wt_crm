<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/15
 * Time: 11:57
 */
?>
<option value="0">医疗团</option>
<?php if(isset($groups) && $groups) foreach($groups as $v):?>
	<option value="<?=$v['id']?>"><?=$v['name']?></option>
<?php endforeach;?>
