<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>添加备注</title>
	<script src="js/mui.min.js"></script>
	<script src="js/mui.picker.js"></script>
	<script src="js/mui.poppicker.js"></script>
	<link href="css/mui.min.css" rel="stylesheet" />
	<link href="css/mui.picker.css" rel="stylesheet" />
	<link href="css/feedback-page.css" rel="stylesheet" />
	<link href="css/mui.poppicker.css" rel="stylesheet" />


	<script src="js/jquery-2.2.2.min.js"></script>

	<script type="text/javascript" charset="UTF-8">
		(function($, doc) {
			$.init();
		})(mui, document);
	</script>
	<style>
		.title {
			margin: 20px 15px 10px;
			color: #6d6d72;
			font-size: 15px;
		}

		.oa-contact-cell.mui-table .mui-table-cell {
			padding: 11px 0;
			vertical-align: middle;
		}

		.oa-contact-cell {
			position: relative;
			margin: -11px 0;
		}

		.oa-contact-avatar {
			width: 75px;
		}

		.oa-contact-avatar img {
			border-radius: 50%;
		}

		.oa-contact-content {
			width: 100%;
		}

		.oa-contact-name {
			margin-right: 20px;
		}

		.oa-contact-name,
		oa-contact-position {
			float: left;
		}

		.my-btn {
			font-family: 'Helvetica Neue', Helvetica, sans-serif;
			line-height: 1.1;
			padding: 10px 15px;
		}

		.mui-control-content {
			margin-top: 10px;
		}

		a.h-btn {
			margin-left: 30px;
		}

		.h-div {
			text-align: center;
			margin-top: 20px;
		}
		.mt10{
			margin-top: 20px;
		}

	</style>

</head>

<body>

<nav class="mui-bar mui-bar-tab">
	<a class="mui-tab-item mui-active" href="#tabbar">
		<span class="mui-icon mui-icon-compose"></span>
		<span class="mui-tab-label">文字</span>
	</a>
	<a class="mui-tab-item" href="#picbar">
		<span class="mui-icon mui-icon-image"></span>
		<span class="mui-tab-label">图片</span>
	</a>
	<a class="mui-tab-item" href="#tabbar-with-contact">
		<span class="mui-icon mui-icon-upload"></span>
		<span class="mui-tab-label">文件</span>
	</a>

</nav>
<div class="mui-content">
	<div id="tabbar" class="mui-control-content mui-active">
		<p>备注项目：</p>
		<div class="row mui-input-row">
			<button  id="showUserPicker1" class="my-btn mui-btn-block" value="0"  type='button'>选择备注项目</button>
		</div>
		<p>内容：</p>
		<div class="row mui-input-row">
			<textarea id='question' class="mui-input-clear question text_data" placeholder="请详细描述你遇到的问题..."></textarea>
		</div>
		<ul class="mui-table-view">

			<li class="mui-table-view-cell">
				允许用户查看
				<div id="user_view1" class="mui-switch">
					<div class="mui-switch-handle"></div>
				</div>
			</li>
		</ul>
		<div class="h-div">
			<button type="button" class="h-btn mui-btn mui-btn-green content_type" value="1">提交</button>
			<a href="javascript:history.go(-1);" type="button" class="h-btn mui-btn mui-btn-red">取消</a>
		</div>

	</div>
	<div id="picbar" class="mui-control-content mui-page ">

		<p>备注项目：</p>
		<div class="row mui-input-row">

			<button  id="showUserPicker2" class="my-btn mui-btn-block" value="0" type='button'>选择备注项目</button>
		</div>
		<p>图片：</p>
		<div class="feedback row mui-input-row">
			<div id='image-list' class="row image-list">

			</div>
		</div>


		<ul class="mui-table-view mt10">

			<li class="mui-table-view-cell">
				允许用户查看
				<div id="user_view2" class="mui-switch">
					<div class="mui-switch-handle"></div>
				</div>
			</li>
		</ul>
		<div class="h-div">
			<button class="h-btn mui-btn mui-btn-green content_type" value="2">提交</button>
			<a href="javascript:history.go(-1);" class="h-btn mui-btn mui-btn-red">取消</a>
		</div>




	</div>
	<div id="tabbar-with-contact" class="mui-control-content">
		<p>备注项目：</p>
		<div class="row mui-input-row">

			<button  id="showUserPicker3" class="my-btn mui-btn-block" value="0" type='button'>选择备注项目</button>
		</div>
		<p>内容：</p>
		<div class="row mui-input-row ">
			<input type="file" class="file_data" name="" id="" value="" />
		</div>
		<ul class="mui-table-view mt10">

			<li class="mui-table-view-cell">
				允许用户查看
				<div id="user_view3" class="mui-switch">
					<div class="mui-switch-handle"></div>
				</div>
			</li>
		</ul>
		<div class="h-div">
			<button type="button" class="h-btn mui-btn mui-btn-green content_type" value="3">提交</button>
			<a href="javascript:history.go(-1);" type="button" class="h-btn mui-btn mui-btn-red">取消</a>
		</div>

	</div>
</div>


</body>
<script src="js/feedback-page.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	var mui_data = {
		types  :   <?=$types?>
	};
	(function($, doc) {
		$.init();
		$.ready(function() {
			var tuanPicker = new $.PopPicker({
				layer: 1
			});
			tuanPicker.setData(mui_data.types);
			var showTuanPickerButton1 = doc.getElementById('showUserPicker1');
			var showTuanPickerButton2 = doc.getElementById('showUserPicker2');
			var showTuanPickerButton3 = doc.getElementById('showUserPicker3');
			showTuanPickerButton1.addEventListener('tap', function(event) {
				tuanPicker.show(function(items) {
					showTuanPickerButton1.innerText =  items[0].text;
					set_select_value("#showUserPicker1",items[0].value);
					//返回 false 可以阻止选择框的关闭
					//return false;
				});
			}, false);
			showTuanPickerButton2.addEventListener('tap', function(event) {
				tuanPicker.show(function(items) {
					showTuanPickerButton2.innerText =  items[0].text;
					set_select_value("#showUserPicker2",items[0].value);
					//返回 false 可以阻止选择框的关闭
					//return false;
				});
			}, false);
			showTuanPickerButton3.addEventListener('tap', function(event) {
				tuanPicker.show(function(items) {
					showTuanPickerButton3.innerText =  items[0].text;
					set_select_value("#showUserPicker3",items[0].value);
					//返回 false 可以阻止选择框的关闭
					//return false;
				});
			}, false);

		});
	})(mui, document);
</script>
<script>
	//提交表单
	$("body").on('click','.content_type',function(){

		var data = get_data($(this).val());

		add_commit(data);
	});

	//设置下拉选框的值
	function set_select_value(object,value){
		$(object).val(value);
	}

	//获取 是否允许用户查看选择
	function get_user_view(content_type){
		var next_day = 0;
		var isActive = document.getElementById("user_view" + content_type).classList.contains("mui-active");

		if(isActive){
			next_day = 1;
		}

		return next_day;
	}

	//获取要提交的数据
	function get_data(content_type){
		var formdata = new FormData();

		var select_data = $("#showUserPicker" + content_type).val();


		//选择备注项目  general_note_type
		if(select_data == 0){
			alert("请选择备注项目！");
			return false;
		}else{
			formdata.append('general_note_type',select_data);
		}

		/**
		 * 异常备注情况
		 */
		formdata.append('type', "<?=$type?>");//异常备注类型
		formdata.append('visit_id', "<?=$visit_id?>");//异常备注所属回访记录

		formdata.append('content_type', content_type);//备注内容类型（文字/图片/文件）
		formdata.append('mgu_id',"<?=$mgu_id?>"); //所属疗程
		formdata.append('user_view',get_user_view(content_type));



		//获取备注内容
		if(content_type == 1){
			formdata.append('content_text',$(".text_data").val());
		}else if(content_type == 2){
			var img_data = document.getElementsByClassName("img_data");

			for(var i=0;i<img_data.length;i++){
				formdata.append('content_img_'+ i, img_data[i].files[0]);
			}
		}else if(content_type == 3){
			var file_data = document.getElementsByClassName("file_data")[0];
			formdata.append('content_file', file_data.files[0]);
		}

		return formdata;
	}

	function add_commit(formdata){

		var url = "<?=\yii\helpers\Url::toRoute("visit/visit_note_save")?>";

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
					history.go(-1);
				}else{
					alert(msg.error);
				}
			},
			error:function(XmlHttpRequest,textStatus,errorThrown){
//				alert('添加失败!');
//				console.log(XmlHttpRequest);
//				console.log(textStatus);
//				console.log(errorThrown);
			}
		});
	}
</script>
</html>