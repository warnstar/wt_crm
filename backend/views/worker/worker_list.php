<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/8
 * Time: 22:19
 */
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-职员列表</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有职员</h5>
					<div class="ibox-tools">
						<a href="<?=\yii\helpers\Url::toRoute("worker/add")?>" class="btn btn-primary btn-xs">添加新职员</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
							<div style="overflow: hidden;float: left;">
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline brand_data worker_filter">
										<option value="0">品牌</option>
										<?php foreach($brands as $b):?>
										<option value="<?=$b['id']?>"><?=$b['name']?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline area_data worker_filter">
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
									<select style="width: 120px;float: left;" class="form-control m-b role_data worker_filter" name="role_id">
										<option value="0">角色</option>
										<?php if($roles) foreach($roles as $v):?>
											<option value="<?=$v['id']?>"><?=$v['name']?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<div class="input-group">
								<input style="width: 300px;margin-left: 30px;" type="text" placeholder="请输入手机号/姓名查询" class="input-sm form-control search_data"> <span style="float:left" class="input-group-btn">
                                        <button type="button"  class="btn btn-sm btn-primary search_click"> 搜索</button> </span>
							</div>

						</div>

					</div>

					<div class="project-list list_data">
						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>姓名</td>
								<td>性别</td>
								<td>角色</td>
								<td>品牌</td>
								<td>区域</td>
								<td>微信昵称</td>
								<td>操作</td>
							</tr>
							</thead>

							<tbody align="center">
							<?php foreach($workers as $v):?>
							<tr>
								<td class="project-status"><?=$v['name']?></td>
								<td class="project-title"><?=$v['sex'] == 1 ? "男":"女"?></td>
								<td class="project-title"><?=$v['role_name']?></td>
								<td class="project-title"><?=$v['brand_name']?></td>
								<td class="project-title"><?=$v['area_name']?></td>
								<td class="project-title"><?=$v['wechat']?></td>

								<td >
									<a href="<?=\yii\helpers\Url::toRoute("worker/detail") . "&id=" . $v['id']?>" class=" btn btn-white btn-sm">查看详情</a>
									<button value="<?=$v['id']?>" class="btn-delete btn btn-white btn-sm delete_click">删除</button>
								</td>
							</tr>
							<?php endforeach;?>
							</tbody>
						</table>
						<div class="pages" style="width:80%;margin:0 auto;text-align: center;">
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
		var url = "<?=\yii\helpers\Url::toRoute("worker/list_ajax")?>";
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
		var url = "<?=\yii\helpers\Url::toRoute("worker/list_ajax")?>";

		var data = {
			brand_id        :   $(".brand_data").val(),
			area_id         :   $(".area_lower_data").val(),
			area_higher_id  :   $(".area_data").val(),
			role_id       :   $(".role_data").val()
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
	});

	//删除操作
	$("body").on("click",".delete_click",function(){
		var url = "<?=\yii\helpers\Url::toRoute("worker/delete")?>";
		var data = {
			id  :   $(this).val()
		};
		$.post(url,data,function(msg){
			if(msg.status){
				alert("删除成功");
				location.reload();
			}else{
				alert(msg.error);
			}
		},'json');
	});
</script>