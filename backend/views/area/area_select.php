<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/10
 * Time: 15:57
 */
?>
<option value="0">区域</option>
<?php if(isset($areas) && $areas) foreach($areas as $l):?>
<option value="<?=$l['id']?>"><?=$l['name']?></option>
<?php endforeach;?>
