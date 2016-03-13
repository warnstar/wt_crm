<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/12
 * Time: 19:03
 */
?>
<style type="text/css">
	.form-control{
		width: 30%;
	}
</style>
<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
	<div class="col-lg-10">
		<h2>回访管理-创建备注</h2>
	</div>

</div>
<!-- 标题 -->

<div class="row">
	<div class="col-lg-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>创建新的备注项</h5>
			</div>

			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="signupForm" >
					<div class="form-group">
						<label class="col-sm-2 control-label">备注名称</label>
						<input type="hidden" class="id_data" value="<?=$note_type['id']?>">
						<div class="col-sm-10">
							<input type="text" class="form-control name_data" value="<?=$note_type['name']?>"  name="name" >
						</div>
					</div>



					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
							<button class="btn btn-primary form_commit" type="submit">提交</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(".form_commit").click(function(){
		var name = $(".name_data").val();
		if(!name){
			alert("备注名称不能为空！");
		}else{
			add_commit();
		}
	});
	function add_commit(){
		var url = "<?=\yii\helpers\Url::toRoute("note/note_type_save")?>";
		var data = {
			id      :   $(".id_data").val(),
			name    :   $(".name_data").val()
		};

		$.post(url,data,function(msg){
			if(msg.status){
				alert("操作成功！");
				location.href = "<?=\yii\helpers\Url::toRoute("note/note_type_list")?>";
			}else{
				alert(msg.error);
			}
		},'json')
	}
</script>