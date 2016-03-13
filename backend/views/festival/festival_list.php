<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/12
 * Time: 16:16
 */
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>节日管理-所有节日</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>节日列表</h5>
					<div class="ibox-tools">
						<a href="<?=\yii\helpers\Url::toRoute("festival/add")?>" class="btn btn-primary btn-xs">新建节日</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>


						</div>

					</div>


					<div class="project-list">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>节日名称</td>
								<td>节日时间</td>
								<td>节日问候语</td>

								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">
							<?php if($festivals) foreach($festivals as $v):?>
							<tr>
								<td class="project-status"><?=$v['name']?></td>
								<td class="project-title"><?=date('n月j日',$v['start_time'])?></td>
								<td class="project-title"><?=$v['greeting']?></td>
								<td >
<!--									<a class=" btn btn-white btn-sm">编辑</a>-->
									<button class="btn-delete btn btn-white btn-sm delete_data" value="<?=$v['id']?>">删除</button>
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
	$(".delete_data").on("click",function(){
		var url = "<?=\yii\helpers\Url::toRoute("festival/delete")?>";
		var data = {
			id      :   $(this).val()
		};

		$.post(url,data,function(msg){
			if(msg.status){
				alert("操作成功！");
				location.href = "<?=\yii\helpers\Url::toRoute("festival/list")?>";
			}else{
				alert(msg.error);
			}
		},'json')
	})
</script>