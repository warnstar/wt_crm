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
	.beizhu-b button{
		margin: 0 auto;
		display: block;
	}
	#foot{
		margin-bottom: 30px;
	}
</style>

<body>
<div class="mui-content">
	<ul class="mui-table-view">

		<li class="mui-table-view-cell">
			<a>姓名<span class="mui-pull-right">张三</span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>年龄<span class="mui-pull-right">19</span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>性別<span class="mui-pull-right">男</span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>HN<span class="mui-pull-right">G135847</span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>疗程名称<span class="mui-pull-right">泰浪漫</span></a>
		</li>
		<li class="mui-table-view-cell">
			<a>状态<span class="mui-pull-right">疗程中</span></a>
		</li>
		<li class="mui-table-view-cell">
			<p class="beizhu-p">注意事项</p>
			<span class="mui-pull-left beizhu">平时多喝水</span>
		</li>
	</ul>
	<ul class="mui-table-view">

		<li class="mui-table-view-cell">
			<p  class="beizhu-p">备注内容为图片</p>
								<span class=" head mui-pull-left beizhu">
									<img class="head-img mui-action-preview" id="head-img1" src="images/2624登录码.jpeg"/>
									<img class="head-img mui-action-preview" id="head-img1" src="images/二维码.png"/>
									<img class="head-img mui-action-preview" id="head-img1" src="images/logo.png"/>
								</span>
		</li>
		<li class="mui-table-view-cell">
			<p class="beizhu-p">备注内容为文字</p>
			<span class="mui-pull-left beizhu">很多啊收到货就看上就卡死的暗示的空间和空间按时打卡上</span>

		</li>
		<li class="mui-table-view-cell">
			<p class="beizhu-p">备注内容为文件</p>
					<span class="mui-pull-left beizhu">
						<a href="a.txt">hah.txt</a>
					</span>
		</li>
	</ul>
</div>
<div class="mui-content-padded beizhu-b">
	<a type="button" href="<?=\yii\helpers\Url::toRoute("user/mgu_list")?>" class="mui-btn mui-btn-primary mui-btn-outlined">
		查看健康足迹
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