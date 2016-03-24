<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/15
 * Time: 19:50
 */
?>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>出团管理-成员导入结果</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInUp">

			<div class="ibox">
				<div class="ibox-title">
					<h5>成员导入结果</h5>

				</div>
				<div class="ibox-content">
					<div class="row m-b-sm m-t-sm">
						<div class="col-md-1"style="width: 100%;">
							<button onclick="location.reload()" style="float:left;" type="button" id="loading-example-btn" class=" btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
						</div>
					</div>

					<div class="project-list list_data">

						<table class="table table-hover">
							<thead>
							<tr align="center">
								<td>姓名</td>
								<td>性别</td>
								<td>手机号</td>
								<td>护照号</td>
								<td>出生年月</td>
								<td>HN</td>
								<td>品牌</td>
								<td>所属区域</td>
							</tr>
							</thead>
							<tbody align="center">
							<?php if(isset($users) && $users) foreach($users as $v):?>
							<tr>
								<td class="project-status"><?=$v['name']?></td>
								<td class="project-title"><?=$v['sex'] == 1 ? "男" : "女"?></td>
								<td class="project-title"><?=$v['phone']?></td>
								<td class="project-title"><?=$v['passport']?></td>
								<td class="project-title"><?=date("m/d/Y",$v['birth'])?></td>
								<td class="project-title"><?=$v['cases_code']?></td>
								<td class="project-title"><?=$v['brand_name']?></td>
								<td class="project-title"><?=$v['area_name']?></td>
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
