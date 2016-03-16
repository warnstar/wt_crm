<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/14
 * Time: 14:21
 */
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>出团管理-添加团员</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有客户</h5>
					<div class="ibox-tools">

						<button type="button" class="btn btn-primary  btn-xs" data-toggle="modal" data-target="#myModal2">
							从excel表格导入
						</button>
						<div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content animated flipInY">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title">从excel中导入数据</h4>
										<small class="font-bold">请选择一个excel文件</small>
									</div>
									<div class="modal-body">
										<input type="file" name="file" id="file">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
										<button type="button" id="upfile" class="btn btn-primary">确定</button>
									</div>
								</div>
							</div>
						</div>
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
									<select class="input-sm form-control input-s-sm inline worker_filter">
										<option value="0">医疗团</option>
										<option value="1">第十期</option>
										<option value="2">第十一期</option>
									</select>
								</div>
							</div>
							<div class="input-group">
								<input style="width: 300px;margin-left: 30px;" type="text" placeholder="请输入手机号/病历号/护照号/姓名查询" class="input-sm form-control search_data"> <span style="float:left" class="input-group-btn">
                                        <button type="button"  class="btn btn-sm btn-primary search_click"> 搜索</button> </span>
							</div>

						</div>

					</div>

					<div class="project-list">

						<table class="table table-hover">
							<thead>
							<tr >
								<th>姓名</th>
								<th>性别</th>
								<th>年龄</th>
								<th>护照号</th>
								<th>操作</th>
							</tr>
							</thead>
							<tbody>
							<?php if($users) foreach($users as $v):?>
								<tr>
									<td class="project-status"><?=$v['name']?></td>
									<td class="project-title"><?=$v['sex'] == 1 ? '男' : '女'?></td>
									<td class="project-title"><?=date('Y',time())-date('Y',$v['birth'])?></td>
									<td class="project-title"><?=$v['passport']?></td>

									<td >
										<button class=" btn btn-white btn-sm add handle add_click" group_id="<?=$group_id?>" user_id="<?=$v['id']?>"  data-id='3' >添加</button>
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

<!-- 以下是添加团员的框框 -->
<div class="modal inmodal" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInX">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">添加团员</h4>
				<small class="font-bold">请完善一下信息</small>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<label class="col-sm-2 control-label">疗程时间</label>
					<div class="col-sm-10">
						<input type="text" class="end_time" placeholder="单位：天" value="10" name="" id="">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
				<button type="button" id="sureadd" class="btn btn-primary" data-dismiss="modal">确定</button>
			</div>
		</div>
	</div>
</div>
<!-- 以上是添加团员的框框 -->
<script type="text/javascript">

	$('#upfile').click(function(event) {

		$('#myModal2').modal('hide');
		var i = layer.load('上传中');
		//layer.close(i);  关闭上传中
	});

	//弹窗
	function show_add(){
		$('#myModal3').modal('show');
		$('#sureadd').attr('data-id', $(this).attr('data-id'));
		$(this).removeClass('add').addClass('added');
	}

	var create_data = {
		group_id    :   0,
		user_id     :   0
	};
	//弹出弹窗
	$("body").on("click",".add_click",function(){
		create_data.group_id = $(this).attr("group_id");
		create_data.user_id = $(this).attr("user_id");

		show_add();
	});
	//提交创建
	$("#sureadd").click(function(){
		var url = "<?=\yii\helpers\Url::toRoute("mgu/save")?>";
		var data  = {
			group_id    :   create_data.group_id,
			user_id     :   create_data.user_id,
			end_time    :   $(".end_time").val()
		};
		console.log(data);
		$.post(url,data,function(msg){
			if(msg.status){
				alert("添加成功！");
				location.reload();
			}else{
				alert(msg.error);
			}
		},'json');
	})
</script>
