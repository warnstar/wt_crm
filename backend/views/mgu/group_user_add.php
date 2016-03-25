<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/14
 * Time: 14:21
 */
$privilege = Yii::$app->session->get("worker");
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
										<input type="file" class="excel_data" name="file" id="file">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
										<button type="button" id="upfile" class="btn btn-primary commit_click">确定</button>
									</div>
								</div>
							</div>
						</div>
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
							<?php $pages->route = "mgu/add_ajax";?>
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

		//$('#myModal2').modal('hide');
		//var i = layer.load('上传中');
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
		var url = "<?=\yii\helpers\Url::toRoute("mgu/add_ajax")?>";
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
		var url = "<?=\yii\helpers\Url::toRoute("mgu/add_ajax")?>";

		var data = {
			brand_id                :   $(".brand_data").val(),
			area_id                 :   $(".area_lower_data").val(),
			area_higher_id          :   $(".area_data").val(),
			medical_group_id        :   "<?=$group_id?>"
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



<script>

	$(".excel_data").on("change",function(){
		var files = !!this.files ? this.files : [];
		if (!files.length || !window.FileReader) return;
		var excel = files[0];


		var re= new RegExp('(.xlsx)');
		if(!re.test(excel.name)){
			alert("请传入.xlsx文件");
			$(".excel_data").val("");
		}

	});

	$(".commit_click").click(function(){
		add_commit();
	});

	function add_commit(){
		var formdata = new FormData();
		var url = "<?=\yii\helpers\Url::toRoute("group/group_user_import")?>";


		var file_data = document.getElementsByClassName("excel_data")[0];
		formdata.append('excel_data', file_data.files[0]);
		formdata.append('group_id',"<?=$group_id?>");

		var mask = layer.load('上传中');
		$.ajax({
			url:url,
			type:'POST',
			data:formdata,
			dataType:'json',
			processData: false,  // 告诉jQuery不要去处理发送的数据
			contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
			success:function(msg){
				if(msg.status){
					location.href = "<?=\yii\helpers\Url::toRoute("group/excel_import_result")?>";
				}else{
					alert("没有一行数据符合要求，导入数据失败！");
					location.reload();
				}
				layer.close(mask);
			},
			error:function(XmlHttpRequest,textStatus,errorThrown){
				layer.close(mask);
			}
		})
	}
</script>