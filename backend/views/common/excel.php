<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/17
 * Time: 10:52
 */
?>
<script src="js/plugins/fancybox/jquery.fancybox.js"></script>
<link href="js/plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
<style type="text/css">
	.form-control{
		width: 30%;
	}
	.beizhu_p{
		width: 30%;
		word-break:break-all;
	}
	.beizhu_p{
		width: 30%;
		word-break:break-all;
	}
	.beizhu_img{
		width: 100px !important;
		height: auto !important;
	}
	.beizhu_wenjian{
		line-height: 35px;
	}
</style>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>用户管理-回访记录详情</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>回访记录详情</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >

					<div class="form-group">
						<label class="col-sm-2 control-label">回访时间</label>

						<div class="col-sm-10">
							<input class="excel_data" type="file">
						</div>
					</div>

					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<a  class="btn btn-primary commit_click" >提交</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


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
		var url = "<?=\yii\helpers\Url::toRoute("common/excel_save")?>";


		var file_data = document.getElementsByClassName("excel_data")[0];
		formdata.append('excel_data', file_data.files[0]);

		$.ajax({
			url:url,
			type:'POST',
			data:formdata,
			dataType:'json',
			processData: false,  // 告诉jQuery不要去处理发送的数据
			contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
			success:function(msg){
				if(msg.status){
					alert("创建成功！");
				}else{
					alert(msg.error);
				}
			},
			error:function(XmlHttpRequest,textStatus,errorThrown){

			}
		})
	}
</script>