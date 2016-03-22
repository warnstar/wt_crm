<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/9
 * Time: 21:26
 */
?><!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>区域管理-所有区域</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有区域</h5>
					<div class="ibox-tools">
						<a href="<?=\yii\helpers\Url::toRoute("area/add")?>" class="btn btn-primary btn-xs">创建区域</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
							<div style="overflow: hidden;float: left;">
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline higher_data">
										<option value="0">请选择</option>
										<?php $area_h = (new \common\models\Area())->get_lower(0); if($area_h) foreach($area_h as $v):?>
										<option value="<?=$v['id']?>"><?=$v['name']?></option>
										<?php endforeach;?>

									</select>
								</div>


							</div>
							<div class="input-group">
								<input style="width: 300px;margin-left: 30px;" type="text" placeholder="请输入区域名称查询" class="input-sm form-control search_data"> <span style="float:left" class="input-group-btn">
                                        <button type="button"  class="btn btn-sm btn-primary search_click"> 搜索</button> </span>
							</div>

						</div>

					</div>



					<div class="project-list">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>序号</td>
								<td>上级区域</td>
								<td>区域名称</td>

								<td>操作</td>
							</tr>
							</thead>
							<tbody class="list_data" align="center">
							<?php if($areas) foreach ($areas as $v):?>
							<tr>
								<td class="project-status"><?=$v['id']?></td>
								<td class="project-title"><?=$v['parent_name']?></td>
								<td class="project-title"><?=$v['name']?></td>
								<td ><button class="btn-delete btn btn-white btn-sm">删除</button>
								</td>
							</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(".higher_data").change(function(){
		var url = "<?=\yii\helpers\Url::toRoute("area/list_ajax")?>";
		var data = {
			id  :   $(this).val()
		};
		if(data.id == 0){
			delete data.id;
		}
		$.get(url,data,function(msg){
			$(".list_data").empty();

			$(".list_data").html(msg);
		})
	});
	$(".search_click").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("area/list_ajax")?>";
		var data = {
			search  :   $(".search_data").val()
		};
		if(!data.search){
			delete data.search;
		}
		$.get(url,data,function(msg){
			$(".list_data").empty();

			$(".list_data").html(msg);
		})
	})
</script>