<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/14
 * Time: 17:53
 */
?>

<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>出团管理-查看团员</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>所有团员</h5>
					<div class="ibox-tools">
						<a href="projects.html" class="btn btn-primary btn-xs">导出excel表格</a>
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

					<div class="project-list list_data">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>姓名</td>
								<td>性别</td>
								<td>年龄</td>
								<td>护照号</td>
								<td>品牌</td>
								<td>状态</td>
								<td>操作</td>
							</tr>
							</thead>
							<tbody align="center">
							<?php if($users) foreach($users as $v):?>
								<tr>
									<td class="project-status"><?=$v['name']?></td>
									<td class="project-title"><?=$v['sex'] == 1 ? '男' : '女'?></td>
									<td class="project-title"><?=date('Y',time())-date('Y',$v['birth'])?></td>
									<td class="project-title"><?=$v['passport']?></td>
									<td class="project-title"><?=$v['brand_name']?></td>
									<td class="project-title">疗程中</td>

									<td >
										<button class=" btn btn-white btn-sm">查看详情</button>
										<button class="btn-delete btn btn-white btn-sm">删除</button>
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