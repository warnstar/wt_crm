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
						<a href="<?=\yii\helpers\Url::toRoute("worker/detail")?>" class="btn btn-primary btn-xs">添加新职员</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
							<div style="overflow: hidden;float: left;">
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline">
										<option value="0">请选择</option>
										<option value="1">泰太美</option>
										<option value="2">泰浪漫</option>
关键字
									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline">
										<option value="0">请选择</option>
										<option value="1">南区</option>
										<option value="2">北区</option>

									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline">
										<option value="0">请选择</option>
										<option value="1">广东</option>
										<option value="2">广西</option>

									</select>
								</div>
								<div  class="m-b-xs" style="float: left;width: 120px;margin-left: 10px;">
									<select class="input-sm form-control input-s-sm inline">
										<option value="0">请选择</option>
										<option value="1">第十期</option>
										<option value="2">第十一期</option>
									</select>
								</div>
							</div>
							<div class="input-group">
								<input style="width: 300px;margin-left: 30px;" type="text" placeholder="请输入手机号/姓名查询" class="input-sm form-control"> <span style="float:left" class="input-group-btn">
                                        <button type="button"  class="btn btn-sm btn-primary"> 搜索</button> </span>
							</div>

						</div>

					</div>

					<div class="project-list">

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
							<tr>
								<td class="project-status">张三</td>
								<td class="project-title">男</td>
								<td class="project-title">品牌经理</td>
								<td class="project-title">泰太美</td>
								<td class="project-title">广东</td>
								<td class="project-title">你好啊</td>

								<td >
									<button class=" btn btn-white btn-sm">查看详情</button>
									<button class="btn-delete btn btn-white btn-sm">删除</button>
								</td>
							</tr>
							<tr>
								<td class="project-status">张三</td>
								<td class="project-title">男</td>
								<td class="project-title">品牌经理</td>
								<td class="project-title">泰太美</td>
								<td class="project-title">广东</td>
								<td class="project-title">你好啊</td>

								<td >
									<button class=" btn btn-white btn-sm">查看详情</button>
									<button class="btn-delete btn btn-white btn-sm">删除</button>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$('.btn-delete').on('click', function(){
		var obj = $(this).parent().parent();//记录一下当前元素
		$.layer({
			shade: [0],
			title: '提示',
			area: ['auto','auto'],
			dialog: {
				msg: '您确定要删除这条数据吗？',
				btns: 2,
				type: 0,
				btn: ['确定','取消'],
				yes: function(){

					obj.remove();//删除当前行
					layer.msg('删除成功！',3 , {
						type:1,
						rate: 'bottom',
						shade: [0]
					});
				}, no: function(){
					layer.msg('删除失败！',3 , {
						type:8,
						rate: 'bottom',
						shade: [0]
					});
				}
			}
		});
	});


</script>