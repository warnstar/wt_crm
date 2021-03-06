<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/21
 * Time: 11:23
 */
$privilege = Yii::$app->session->get("worker");
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>客服问题-待处理问题</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有待处理问题</h5>
					<div class="ibox-tools">

					</div>
				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button  onclick="location.reload()" style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
							<div style="overflow: hidden;float: left;">
								<div <?php if($privilege['role_id'] != 1) echo "hidden=hidden";?>  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline brand_data worker_filter">
										<option value="0">品牌</option>
										<?php foreach($brands as $b):?>
											<option value="<?=$b['id']?>"><?=$b['name']?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select  class="input-sm form-control input-s-sm inline area_data worker_filter">
										<option value="0">区域</option>
										<?php foreach($areas as $a):?>
											<option value="<?=$a['id']?>"><?=$a['name']?></option>
										<?php endforeach;?>

									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline area_lower_data worker_filter">
										<option value="0">次级区域</option>

									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline group_data worker_filter">
										<option value="0">医疗团</option>
										<?php if(isset($groups) && $groups) foreach($groups as $v):?>
											<option value="<?=$v['id']?>"><?=$v['name']?></option>
										<?php endforeach;?>

									</select>
								</div>
							</div>
							<div class="input-group">
								<input style="width: 300px;margin-left: 30px;" type="text" placeholder="请输入手机号/病历号/护照号/姓名查询" class="input-sm form-control search_data"> <span style="float:left" class="input-group-btn">
                                        <button type="button"  class="btn btn-sm btn-primary search_click"> 搜索</button> </span>
							</div>

						</div>

					</div>

					<div class="project-list list_data">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>客户姓名</td>
								<td>客服名称</td>
								<td>护照号</td>
								<td>提交时间</td>
								<td>备注</td>
								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">
							<?php if($list) foreach($list as $v ):?>
							<tr>
								<td class="project-status"><?=$v['user_name']?></td>
								<td class="project-title"><?=$v['worker_name']?></td>
								<td class="project-title"><?=$v['user_passport']?></td>
								<td class="project-title"><?=date("m/d/Y",$v['create_time'])?></td>
								<td class="project-title"><?=$v['error_content']?></td>

								<td >
									<a href="<?=\yii\helpers\Url::toRoute("visit/error_do") . "&visit_id=" . $v['id']?>" class=" btn btn-white btn-sm">处理</a>
								</td>
							</tr>
							<?php endforeach;?>
							</tbody>
						</table>
						<div class="pages" style="width:80%;margin:0 auto;text-align: center;">
							<?php $pages->route = "visit/error_un_do_ajax";?>
							<?=
							\yii\widgets\LinkPager::widget([
									'pagination' => $pages,
									'options' => ['class' => 'pagination pull-center', 'style' => 'margin:0px']
							]);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	//品牌--》医疗团联动变化
	$(".brand_data").change(function(){
		var brand_id = $(this).val();
		var url = "<?=\yii\helpers\Url::toRoute("group/group_select")?>";
		var data = {
			brand_id  :   brand_id
		};
		$(".group_data").val(0);
		if(data.brand_id != 0){
			$.get(url,data,function(msg){
				$(".group_data").empty();
				$(".group_data").html(msg);
			})
		}

	});

	//联动变化次级区域
	$(".area_data").change(function(){
		var area_id = $(this).val();
		var url = "<?=\yii\helpers\Url::toRoute("area/area_select")?>";
		var data = {
			id  :   area_id
		};
		$(".area_lower_data").val(0);
		if(data.id != 0){
			$.get(url,data,function(msg){
				$(".area_lower_data").empty();
				$(".area_lower_data").html(msg);
			})
		}

	});

	$(".search_click").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("visit/error_un_do_ajax")?>";
		var data = {
			search  :   $(".search_data").val()
		};
		$.get(url,data,function(msg){
			$(".list_data").empty();

			$(".list_data").html(msg);
		})
	});
	//筛选
	$(".worker_filter").change(function(){
		var url = "<?=\yii\helpers\Url::toRoute("visit/error_un_do_ajax")?>";

		var data = {
			brand_id                :   $(".brand_data").val(),
			area_id                 :   $(".area_lower_data").val(),
			area_higher_id          :   $(".area_data").val(),
			medical_group_id        :   $(".group_data").val()
		};

		if(data.area_id == 0){
			delete data.area_id;
		}
		if(data.area_higher_id == 0){
			delete data.area_higher_id;
		}


		$.get(url,data,function(msg){
			$(".list_data").empty();

			$(".list_data").html(msg);
		})
	});

	//局部刷新
	$(function(){
		$('.list_data').on('click', '.pages a', function(){
			var url = $(this).attr('href');

			$.get(url, '', function(msg){
				$(".list_data").empty();
				$(".list_data").html(msg);
			});
			return false;
		});
	})
</script>