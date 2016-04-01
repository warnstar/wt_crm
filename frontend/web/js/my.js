function my_show (e) {
		e.show();//显示遮罩
			var div = document.createElement('div');
			div.setAttribute('class','h_loding')
			document.getElementsByClassName("mui-backdrop")[0].appendChild(div);
}

function my_close () {
	var div=document.getElementsByClassName("mui-backdrop")[0];
	document.getElementsByClassName("mui-backdrop")[0].setAttribute('style', 'opacity:0');
	
}
				