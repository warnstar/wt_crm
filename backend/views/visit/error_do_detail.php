<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/21
 * Time: 11:26
 */
?>

<style type="text/css">
	.form-control{
		width: 30%;
	}
	.beizhu_p{
		width: 30%;
		word-break:break-all;
	}
	.beizhu_p{
		width: 30%;
		word-break:break-all;
	}
	.beizhu_img{
		width: 100px !important;
		height: auto !important;
	}
	.beizhu_wenjian{
		line-height: 35px;
	}
</style>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>客服问题-处理详情</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>处理详情</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >

					<div class="form-group">
						<label class="col-sm-2 control-label">回访时间</label>

						<div class="col-sm-10">
							<input type="text" disabled class="form-control"  name="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">客户姓名</label>

						<div class="col-sm-10">
							<input type="text" disabled class="form-control"  name="age" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">病历号</label>

						<div class="col-sm-10">
							<input type="text"  disabled class="form-control"  name="phone" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">回访状态</label>

						<div class="col-sm-10">
							<input type="text" disabled class="form-control"  name="passport" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">已通知</label>

						<div class="col-sm-10">
							<input type="text"  disabled class="form-control"  name="hn" >
						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-2 control-label">备注内容为文字</label>

						<div class="col-sm-10">
							<p class="beizhu_p">dasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashjdasjkdhkjsdashj</p>
							<p>备注人：<span>张三（市场总监）</span>&nbsp;&nbsp;&nbsp;备注时间：<span>2015-5-5 5:5:5</span></p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">备注内容为文件</label>

						<div class="col-sm-10">
							<p class="beizhu_wenjian">  <a href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/fonts/fontawesome-webfont.eot">文件</a></p>
							<p>备注人：<span>张三（市场总监）</span>&nbsp;&nbsp;&nbsp;备注时间：<span>2015-5-5 5:5:5</span></p>

						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">备注图片</label>

						<div class="col-sm-10">
							<div>
								<a class="fancybox" href="img/p_big3.jpg" title="图片3">
									<img class="beizhu_img" alt="image" src="img/p_big3.jpg" />
								</a>
								<a class="fancybox" href="img/p_big3.jpg" title="图片1">
									<img class="beizhu_img" alt="image" src="img/p_big3.jpg" />
								</a>
								<a class="fancybox" href="img/p_big3.jpg" title="图片2">
									<img class="beizhu_img" alt="image" src="img/p_big3.jpg" />
								</a>
								<p>备注人：<span>张三（市场总监）</span>&nbsp;&nbsp;&nbsp;备注时间：<span>2015-5-5 5:5:5</span></p>
							</div>

						</div>
					</div>


					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">

							<a class="btn btn-primary" >返回</a>


						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="js/plugins/fancybox/jquery.fancybox.js"></script>


<script>
	$(document).ready(function () {
		$('.fancybox').fancybox({
			openEffect: 'none',
			closeEffect: 'none',
			centerOnScroll:false,

		});
	});

</script>