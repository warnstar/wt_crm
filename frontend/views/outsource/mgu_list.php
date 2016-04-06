<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/28
 * Time: 14:56
 */
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>健康足迹</title>
	<script src="js/mui.min.js"></script>
	<link href="css/mui.min.css" rel="stylesheet"/>
	<script type="text/javascript" charset="UTF-8">
		mui.init();
	</script>
	<style>
		.mui-table h4,.mui-table h5,.mui-table .mui-h5,.mui-table .mui-h6,.mui-table p{
			margin-top: 0;
		}
		.mui-table h4{
			line-height: 21px;
			font-weight: 500;
		}

		.mui-table .oa-icon{
			position: absolute;
			right:0;
			bottom: 0;
		}
		.mui-table .oa-icon-star-filled{
			color:#f14e41;
		}
	</style>
</head>
<body>

<div class="mui-content">
	<ul class="mui-table-view mui-table-view-striped mui-table-view-condensed">
		<?php if($groups) foreach($groups as $v):?>
		<li class="mui-table-view-cell">
			<a href="<?=\yii\helpers\Url::toRoute("outsource/detail") . "&mgu_id=" . $v['id']?>">
				<div class="mui-table">
					<div class="mui-table-cell mui-col-xs-10">
						<h4 class="mui-ellipsis"><?=$v['group_name']?></h4>
						<h5>疗程时间：<?=(int)(($v['end_time']-$v['start_time'])/(3600*24))?>天</h5>
					</div>
					<div class="mui-table-cell mui-col-xs-4 mui-text-right">
						<span class="mui-h5"><?=date("Y-m-d",$v['group_join_time'])?></span>
					</div>
				</div>
			</a>
		</li>
		<?php endforeach;?>

	</ul>
</div>
</body>
</html>