<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/17
 * Time: 10:52
 */
?>
<script src="js/plugins/fancybox/jquery.fancybox.js"></script>
<link href="js/plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
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
		<h2>用户管理-回访记录详情</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>回访记录详情</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >

					<div class="form-group">
						<label class="col-sm-2 control-label">回访时间</label>

						<div class="col-sm-10">
							<input type="text" disabled class="form-control" value="<?=date("Y-m-d H:m:s",$visit['create_time'])?>" name="name" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">客户姓名</label>

						<div class="col-sm-10">
							<input type="text" disabled class="form-control" value="<?=$visit['user_name']?>"  name="age" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">病历号</label>

						<div class="col-sm-10">
							<input type="text"  disabled class="form-control" value="<?=$visit['user_cases_code']?>"  name="phone" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">回访状态</label>

						<div class="col-sm-10">
							<input type="text" disabled class="form-control" value="<?=$visit['type'] == 1 ? "正常" : "异常"?> " name="passport" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">已通知</label>

						<div class="col-sm-10">
							<input type="text"  disabled class="form-control"  name="hn" >
						</div>
					</div>

					<?php if($visit_notes) foreach($visit_notes as $v):?>
						<?php if($v['content_type'] == 1):?>
						<div class="form-group">
							<label class="col-sm-2 control-label">备注内容为文字</label>

							<div class="col-sm-10">
								<p class="beizhu_p"><?=$v['content']?></p>
								<p>备注人：<span><?=$v['worker_name']?>（<?=$v['worker_role']?>）</span>&nbsp;&nbsp;&nbsp;备注时间：<span><?=date("Y-m-d H:m:s",$v['create_time'])?></span></p>
							</div>
						</div>
						<?php endif;?>

						<?php if($v['content_type'] == 3):?>
						<div class="form-group">
							<label class="col-sm-2 control-label">备注内容为文件</label>
							<div class="col-sm-10">
								<?php $content = json_decode($v['content']);?>

								<?php if($content) foreach($content as $file):?>
								<p class="beizhu_wenjian">  <a href="<?=isset($file->url) ? $file->url : ""?>"><?=isset($file->name) ? $file->name : "文件"?></a></p>
								<?php endforeach;?>

								<p>备注人：<span><?=$v['worker_name']?>（<?=$v['worker_role']?>）</span>&nbsp;&nbsp;&nbsp;备注时间：<span><?=date("Y-m-d H:m:s",$v['create_time'])?></span></p>
							</div>
						</div>
						<?php endif;?>

						<?php if($v['content_type'] == 2):?>
						<div class="form-group">
							<label class="col-sm-2 control-label">备注图片</label>

							<div class="col-sm-10">
								<div>
									<?php $content = json_decode($v['content']);?>

									<?php if($content) foreach($content as $img):?>
									<a class="fancybox" href="<?=isset($img->url) ? $img->url : ""?>" title="图片3">
										<img class="beizhu_img" alt="image" src="<?=isset($img->url_object) ? (\common\lib\oss\Oss::IMG_OPTION_ADDR . urlencode($img->url_object) . "@100w") : ""?>" />
									</a>
									<?php endforeach;?>
									<p>备注人：<span><?=$v['worker_name']?>（<?=$v['worker_role']?>）</span>&nbsp;&nbsp;&nbsp;备注时间：<span><?=date("Y-m-d H:m:s",$v['create_time'])?></span></p>
								</div>

							</div>
						</div>
						<?php endif;?>
					<?php endforeach;?>

					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a href="javascript:history.go(-1)" class="btn btn-primary" >返回</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function () {
		$('.fancybox').fancybox({
			openEffect: 'none',
			closeEffect: 'none',
			centerOnScroll:false,

		});
	});

</script>