function my_show (e) {

			if(!document.getElementsByClassName("mui-backdrop")[0]) {

				var w_div = document.createElement('div');
				w_div.setAttribute('class','mui-backdrop');

					var div = document.createElement('div');
					div.setAttribute('class', 'h_loding');
					div.setAttribute('id', 'h_loding');
					w_div.appendChild(div);
					document.getElementsByTagName('body')[0].appendChild(w_div);
				}else{
				document.getElementsByClassName("mui-backdrop")[0].setAttribute('style', 'display:block');
			}

}
function my_close () {
	var div=document.getElementsByClassName("mui-backdrop")[0];
	document.getElementsByClassName("mui-backdrop")[0].setAttribute('style', 'display:none');
	
}
		