<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/13
 * Time: 14:45
 */
$privilege = Yii::$app->session->get("worker");
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>出团管理-出团列表</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有出团</h5>
					<div class="ibox-tools">
						<a href="<?=\yii\helpers\Url::toRoute("group/add")?>" class="btn btn-primary btn-xs">新建出团</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button   onclick="location.reload()" style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
							<div <?php if($privilege['role_id'] != 1) echo "hidden=hidden";?> style="overflow: hidden;float: left;">
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline worker_filter brand_data">
										<option value="0">请选择</option>
										<?php if($brands) foreach($brands as $v):?>
											<option value="<?=$v['id']?>"><?=$v['name']?></option>
										<?php endforeach;?>

									</select>
								</div>

							</div>
							<div class="input-group">
								<input style="width: 300px;margin-left: 30px;" type="text" placeholder="请输入团名称" class="input-sm form-control search_data"> <span style="float:left" class="input-group-btn">
                                        <button type="button"  class="btn btn-sm btn-primary search_click" > 搜索</button> </span>
							</div>

						</div>

					</div>

					<div class="project-list list_data">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>团编号</td>
								<td>团名称</td>
								<td>品牌</td>
								<td>出团时间</td>
								<td>回国时间</td>
								<td>出团人数</td>
								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">
							<?php if($groups) foreach($groups as $v):?>
							<tr>
								<td class="project-status"><?=$v['group_code']?></td>
								<td class="project-title"><?=$v['name']?></td>
								<td class="project-title"><?=$v['brand_name']?></td>
								<td class="project-title"><?=date("Y-m-d",$v['start_time'])?></td>
								<td class="project-title"><?=date("Y-m-d",$v['end_time'])?></td>
								<td class="project-title"><?=$v['user_count']?></td>

								<td >
									<a class=" btn btn-white btn-sm" href="<?=\yii\helpers\Url::toRoute("group/detail") . "&id=" . $v['id']?>">查看详情</a>
									<a class=" btn btn-white btn-sm" href="<?=\yii\helpers\Url::toRoute("mgu/list") . "&medical_group_id=" . $v['id']?>">查看团员</a>
									<button  value="<?=$v['id']?>" class="btn-delete btn btn-white btn-sm delete_click">删除</button>
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

	$(".search_click").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("group/list_ajax")?>";
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
		var url = "<?=\yii\helpers\Url::toRoute("group/list_ajax")?>";

		var data = {
			brand_id        :   $(".brand_data").val()
		};

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

	//删除事件
	$("body").on("click",".delete_click",function(){
		var url = "<?=\yii\helpers\Url::toRoute("group/delete")?>";
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