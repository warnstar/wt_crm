<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>添加客户</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<!--标准mui.css-->
	<link rel="stylesheet" href="./css/mui.min.css">
	<link rel="stylesheet" type="text/css" href="css/mui.poppicker.css"/>
	<link rel="stylesheet" type="text/css" href="css/mui.picker.css"/>
	<link rel="stylesheet" type="text/css" href="css/mui.picker.min.css"/>


	<!--loading 显示-->
	<link rel="stylesheet" type="text/css" href="css/my.css"/>
	<script src="js/my.js" type="text/javascript" charset="utf-8"></script>

	<script src="js/jquery-2.2.2.min.js"></script>
	<!--App自定义的css-->

	<style>
		h5 {
			margin: 5px 7px;
		}
		.mui-content-padded{

			padding-top: 30px;
		}
		.h_span{
			float: right;
			width: 65%;
			margin-bottom: 0;
			padding-left: 0;
			line-height: 21px;
			height: 40px;
			padding: 10px 0px;
			font-size: 17px;
			font-family: 'Helvetica Neue',Helvetica,sans-serif;
			color: #aaa;
		}
	</style>
</head>

<body>

<div class="mui-content">
	<div class="mui-content-padded" style="margin: 5px;">
		<form class="mui-input-group">
			<div class="mui-input-row">
				<label>客户姓名</label>
				<input type="text" class="name_data" placeholder="请输入客户姓名">
			</div>
			<div class="mui-input-row">
				<label>性别</label>
				<span id="sex" class="h_span sex_data">请选择性别</span>
			</div>
			<div class="mui-input-row">
				<label>手机号码</label>
				<input type="number" class="mui-input-clear phone_data" placeholder="请输入客户手机号码">
			</div>
			<div class="mui-input-row">
				<label>护照号</label>
				<input type="text" class="mui-input-clear passport_data" placeholder="请输入客户护照号">
			</div>
			<div class="mui-input-row">
				<label>出生日期</label>
				<span  id="birthday" class="h_span birth_data" data-options='{"type":"date","beginYear":1950,"endYear":2016}'>请选择出生日期</span>
			</div>
			<div class="mui-input-row">
				<label>病历号</label>
				<input type="text" class="mui-input-clear cases_code" placeholder="请输入客户病历号">
			</div>
			<div class="mui-input-row">
				<label>所属区域</label>
				<span id="city" class="h_span area_data">请选择客户所在区域</span>
			</div>
			<div class="mui-button-row">
				<a type="button" class="mui-btn mui-btn-primary commit_click">确认</a>&nbsp;&nbsp;
				<button  type="button" class="mui-btn mui-btn-danger" onclick="history.go(-1);">取消</button>
			</div>
		</form>

	</div>
</div>
<script src="js/mui.min.js"></script>
<script src="js/mui.picker.js" type="text/javascript" charset="utf-8"></script>
<script src="js/mui.poppicker.js" type="text/javascript" charset="utf-8"></script>
<script src="js/mui.dtpicker.js" type="text/javascript" charset="utf-8"></script>
<script>
	var mui_data = {
		areas           :   <?=$areas?>
	};
	(function($, doc) {
		$.init();
		$.ready(function() {
			var sexPicker = new $.PopPicker({
				layer: 1
			});
			sexPicker.setData([{
				value: '1',
				text: '男'

			},{
				value: '2',
				text: '女'

			}]);
			var showSexPickerButton = doc.getElementById('sex');

			showSexPickerButton.addEventListener('tap', function(event) {
				sexPicker.show(function(items) {

					showSexPickerButton.innerText =  items[0].text;
					showSexPickerButton.setAttribute('style','color:#000;');
					set_select_value("#sex",items[0].value);
					//返回 false 可以阻止选择框的关闭
					//return false;
				});
			}, false);
			//-----------------------


			//-----------------------
			var cityPicker = new $.PopPicker({
				layer: 2
			});
			cityPicker.setData(mui_data.areas);
			var showCityPickerButton = doc.getElementById('city');

			showCityPickerButton.addEventListener('tap', function(event) {
				cityPicker.show(function(items) {
					showCityPickerButton.innerText =  items[1].text;
					showCityPickerButton.setAttribute('style','color:#000;');
					set_select_value("#city",items[1].value);
					//返回 false 可以阻止选择框的关闭
					//return false;
				});
			}, false);
			//-----------------------
			var showBirthdayPickerButton = doc.getElementById('birthday');
			showBirthdayPickerButton.addEventListener('tap', function() {
				var optionsJson = this.getAttribute('data-options') || '{}';
				var options = JSON.parse(optionsJson);
				/*
				 * 首次显示时实例化组件
				 * 示例为了简洁，将 options 放在了按钮的 dom 上
				 * 也可以直接通过代码声明 optinos 用于实例化 DtPicker
				 */
				var picker = new $.DtPicker(options);
				picker.show(function(rs) {
					/*
					 * rs.value 拼合后的 value
					 * rs.text 拼合后的 text
					 * rs.y 年，可以通过 rs.y.vaue 和 rs.y.text 获取值和文本
					 * rs.m 月，用法同年
					 * rs.d 日，用法同年
					 * rs.h 时，用法同年
					 * rs.i 分（minutes 的第二个字母），用法同年
					 */
					showBirthdayPickerButton.innerText =rs.text;
					showBirthdayPickerButton.setAttribute('style','color:#000;');

					set_select_value("#birthday",rs.text);
					/*
					 * 返回 false 可以阻止选择框的关闭
					 * return false;
					 */
					/*
					 * 释放组件资源，释放后将将不能再操作组件
					 * 通常情况下，不需要示放组件，new DtPicker(options) 后，可以一直使用。
					 * 当前示例，因为内容较多，如不进行资原释放，在某些设备上会较慢。
					 * 所以每次用完便立即调用 dispose 进行释放，下次用时再创建新实例。
					 */
					picker.dispose();
				});
			}, false);
			//-----------------------
		});
	})(mui, document);


	//设置下拉选框的值
	function set_select_value(object,value){
		$(object).val(value);
	}

	/**
	 * 提交操作
	 */
	$("body").on('click','.commit_click',function(){
		var data = get_users_data();
		if(data){
			add_commit(data);
		}
	});
	//获取页面表单数据
	function get_users_data(){

		var data = {
			name        :   $(".name_data").val(),
			sex         :   $(".sex_data").val(),
			phone       :   $(".phone_data").val(),
			passport    :   $(".passport_data").val(),
			birth       :   $(".birth_data").val(),
			cases_code  :   $(".cases_code").val(),
			area_id     :   $(".area_data").val()
		};

		if(data_validate(data)){
			return data;
		}else{
			return null;
		}
	}
	//表单验证
	function data_validate(data) {

		var flag = true;
		if(!data.name || !data.sex || !data.phone || !data.passport || !data.birth || !data.cases_code || !data.area_id  ){
			alert("不能有空值");
			flag = false;
		}

		if(!checkMobile(data.phone)){
			alert("请输入正确手机号");
			flag = false;
		}

		if(data.area_id == 0){
			alert("请选择区域");
			flag = false;
		}

		return flag;
	}
	function checkMobile(sMobile){
		var flag = true;
	    if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(sMobile))){
		    flag = false;
	    }
		return flag;
	}

	/**
	 * 网络提交
	 */
	function add_commit(data){
		var url = "<?=\yii\helpers\Url::toRoute("users/save")?>";
		//loading 遮罩
		var mask = mui.createMask(function(){return false;});//callback为用户点击蒙版时自动执行的回调；
		my_show(mask);

		$.post(url,data,function(msg){
			my_close();
			if(msg.status){
				alert("操作成功！");
				location.href = "<?=\yii\helpers\Url::toRoute("users/list")?>";
			}else{
				alert(msg.error);
			}

		},'json')
	}
</script>
</body>

</html>