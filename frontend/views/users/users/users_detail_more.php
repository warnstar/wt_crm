<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/28
 * Time: 14:55
 */
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>详情</title>
	<script src="js/mui.min.js"></script>
	<link href="css/mui.min.css" rel="stylesheet" />
	<script type="text/javascript" charset="UTF-8">
		mui.init();
	</script>
</head>
<style>
	html,
	body {
		background-color: #efeff4;
	}

	.mui-views,
	.mui-view,
	.mui-pages,
	.mui-page,
	.mui-page-content {
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		width: 100%;
		height: 100%;
		background-color: #efeff4;
	}

	.mui-pages {
		top: 46px;
		height: auto;
	}

	.mui-scroll-wrapper,
	.mui-scroll {
		background-color: #efeff4;
	}

	.mui-page.mui-transitioning {
		-webkit-transition: -webkit-transform 300ms ease;
		transition: transform 300ms ease;
	}

	.mui-page-left {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
	}

	.mui-ios .mui-page-left {
		-webkit-transform: translate3d(-20%, 0, 0);
		transform: translate3d(-20%, 0, 0);
	}

	.mui-navbar {
		position: fixed;
		right: 0;
		left: 0;
		z-index: 10;
		height: 44px;
		background-color: #f7f7f8;
	}

	.mui-navbar .mui-bar {
		position: absolute;
		background: transparent;
		text-align: center;
	}

	.mui-android .mui-navbar-inner.mui-navbar-left {
		opacity: 0;
	}

	.mui-ios .mui-navbar-left .mui-left,
	.mui-ios .mui-navbar-left .mui-center,
	.mui-ios .mui-navbar-left .mui-right {
		opacity: 0;
	}

	.mui-navbar .mui-btn-nav {
		-webkit-transition: none;
		transition: none;
		-webkit-transition-duration: .0s;
		transition-duration: .0s;
	}

	.mui-navbar .mui-bar .mui-title {
		display: inline-block;
		width: auto;
	}

	.mui-page-shadow {
		position: absolute;
		right: 100%;
		top: 0;
		width: 16px;
		height: 100%;
		z-index: -1;
		content: '';
	}

	.mui-page-shadow {
		background: -webkit-linear-gradient(left, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 10%, rgba(0, 0, 0, .01) 50%, rgba(0, 0, 0, .2) 100%);
		background: linear-gradient(to right, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 10%, rgba(0, 0, 0, .01) 50%, rgba(0, 0, 0, .2) 100%);
	}

	.mui-navbar-inner.mui-transitioning,
	.mui-navbar-inner .mui-transitioning {
		-webkit-transition: opacity 300ms ease, -webkit-transform 300ms ease;
		transition: opacity 300ms ease, transform 300ms ease;
	}

	.mui-page {
		display: none;
	}

	.mui-pages .mui-page {
		display: block;
	}

	.mui-page .mui-table-view:first-child {
		margin-top: 15px;
	}

	.mui-page .mui-table-view:last-child {
		margin-bottom: 30px;
	}

	.mui-table-view {
		margin-top: 20px;
	}

	.mui-table-view span.mui-pull-right {
		color: #999;
	}

	.mui-table-view-divider {
		background-color: #efeff4;
		font-size: 14px;
	}

	.mui-table-view-divider:before,
	.mui-table-view-divider:after {
		height: 0;
	}

	.head {
		height: 40px;
	}

	#head {
		line-height: 40px;
	}

	.head-img {
		width: 40px;
		height: 40px;
	}

	#head-img1 {
		float: right;
		width: 40px;
		height: 40px;
		margin-right: 2px;
	}

	.update {
		font-style: normal;
		color: #999999;
		margin-right: -25px;
		font-size: 15px
	}

	.mui-fullscreen {
		position: fixed;
		z-index: 20;
		background-color: #000;
	}

	.mui-ios .mui-navbar .mui-bar .mui-title {
		position: static;
	}
	.beizhu{
		padding: 0 8px;
		font-size: 14px;
	}
	.beizhu-p{
		color: #000000;
	}
	.beizhu-b a{
		margin: 0 auto;
		display: block;
		width:40%;
	}
	#foot{
		margin-bottom: 30px;
	}
</style>

<body>
<div class="mui-content">
	<ul class="mui-table-view">

		<li class="mui-table-view-cell">
			<a>姓名<span class="mui-pull-right"><?=$user['name']?></span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>年龄<span class="mui-pull-right"><?=date("Y",time())-date("Y",$user['birth'])?></span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>性別<span class="mui-pull-right"><?=$user['sex'] == 1 ? "男" : "女"?></span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>HN<span class="mui-pull-right"><?=$user['cases_code']?></span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>疗程状态<span class="mui-pull-right">
					<?php
					if(!$user['last_mgu'])
						echo "无疗程";
					else if($user['start_time'] > time())
						echo "未开始";
					else if($user['end_time'] < time()){
						echo "已结束";
					}else{
						echo "疗程中";
					}
					?>
			</span></a>
		</li>
		<li class="mui-table-view-cell">
			<p class="beizhu-p">注意事项</p>
			<span class="mui-pull-left beizhu"><?=$user['brand_attention']?></span>
		</li>
	</ul>


	<?php if($visit_notes) foreach($visit_notes as $v):?>
		<ul class="mui-table-view">
			<?php if($v['content_type'] == 2):?>
				<li class="mui-table-view-cell">
					<p  class="beizhu-p"><?=$v['type_name'] ? $v['type_name'] : "异常备注"?></p>
				<span class=" head mui-pull-left beizhu">
					<?php $content = json_decode($v['content']);?>

					<?php if($content) foreach($content as $img):?>

						<img class="head-img mui-action-preview" id="head-img1" src="<?=isset($img->url_object) ? (\common\lib\oss\Oss::IMG_OPTION_ADDR . urlencode($img->url_object) . "@640w") : ""?>"/>
					<?php endforeach;?>
				</span>
				</li>
			<?php endif;?>

			<?php if($v['content_type'] == 1):?>
				<li class="mui-table-view-cell">
					<p class="beizhu-p"><?=$v['type_name'] ? $v['type_name'] : "异常备注"?></p>
					<span class="mui-pull-left beizhu"><?=$v['content']?></span>

				</li>
			<?php endif;?>

			<?php if($v['content_type'] == 3):?>
				<li class="mui-table-view-cell">
					<p class="beizhu-p"><?=$v['type_name'] ? $v['type_name'] : "异常备注"?></p>
				<span class="mui-pull-left beizhu">
					<?php $content = json_decode($v['content']);?>

					<?php if($content) foreach($content as $file):?>
						<a href="<?=isset($file->url) ? $file->url : ""?>"><?=isset($file->name) ? $file->name : "文件"?></a>
					<?php endforeach;?>
				</span>
				</li>
			<?php endif;?>
		</ul>
	<?php endforeach;?>

</div>
<div class="mui-content-padded beizhu-b">
	<a type="button" href="<?=\yii\helpers\Url::toRoute("users/mgu_list")?>" class="mui-btn mui-btn-primary mui-btn-outlined">
		查看健康足迹
	</a>
	<a href="<?=\yii\helpers\Url::toRoute("visit/visit_list") . "&mgu_id=" . $mgu_id?>"  type="button" class="mui-btn mui-btn-primary mui-btn-outlined">
		回访记录
	</a>
</div>
<div id="foot">

</div>
</body>

</html>
<script type="text/javascript">
	function initImgPreview() {
		var imgs = document.querySelectorAll("img.mui-action-preview");
		imgs = mui.slice.call(imgs);
		if (imgs && imgs.length > 0) {
			var slider = document.createElement("div");
			slider.setAttribute("id", "__mui-imageview__");
			slider.classList.add("mui-slider");
			slider.classList.add("mui-fullscreen");
			slider.style.display = "none";
			slider.addEventListener("tap", function() {
				slider.style.display = "none";
			});
			slider.addEventListener("touchmove", function(event) {
				event.preventDefault();
			})
			var slider_group = document.createElement("div");
			slider_group.setAttribute("id", "__mui-imageview__group");
			slider_group.classList.add("mui-slider-group");
			imgs.forEach(function(value, index, array) {
				//给图片添加点击事件，触发预览显示；
				value.addEventListener('tap', function() {
					slider.style.display = "block";
					_slider.refresh();
					_slider.gotoItem(index, 0);
				})
				var item = document.createElement("div");
				item.classList.add("mui-slider-item");
				var a = document.createElement("a");
				var img = document.createElement("img");
				img.setAttribute("src", value.src);
				a.appendChild(img)
				item.appendChild(a);
				slider_group.appendChild(item);
			});
			slider.appendChild(slider_group);
			document.body.appendChild(slider);
			var _slider = mui(slider).slider();
		}
	}
	initImgPreview();
</script>