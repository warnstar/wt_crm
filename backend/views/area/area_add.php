<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/9
 * Time: 21:38
 */
?>
<style type="text/css">
	.form-control{
		width: 30%;
	}
</style>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>区域管理-新建区域</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>新建区域</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >

					<div class="form-group">
						<label class="col-sm-2 control-label">上级区域</label>

						<div class="col-sm-10"  >
							<select style="width: 110px;float: left;" class="form-control m-b parent_data" name="area_id">
								<option value="0">主区域</option>
								<?php if($area_higher) foreach($area_higher as $v):?>
								<option value="<?=$v['id']?>"><?=$v['name']?></option>
								<?php endforeach;?>
							</select>

						</div>

					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">区域名称</label>

						<div class="col-sm-10">
							<input type="text" class="form-control name_data" name="name" >
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a class="btn btn-primary submit" type="submit">确定</a>
							<a href="<?=\yii\helpers\Url::toRoute("common/home")?>" class="btn btn-primary" >取消</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(".submit").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("area/save")?>";
		var data = {
			name            :   $(".name_data").val(),
			parent_id       :   $(".parent_data").val()
		};

		$.post(url,data,function(msg){
			if(msg.status){
				alert("操作成功！");
				location.href = "<?=\yii\helpers\Url::toRoute("area/list")?>";
			}else{
				alert(msg.error);
			}
		},'json')
	})
</script>