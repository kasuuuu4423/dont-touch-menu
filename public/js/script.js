$(() => {
	var arg = new Object;
	var pair=location.search.substring(1).split('&');
	for(var i=0;pair[i];i++) {
		var kv = pair[i].split('=');
		arg[kv[0]]=kv[1];
	}
	var m = 60*60  // 秒で指定
	document.cookie = "id=" + arg['user'] + ";max-age=" + m + ";domain=https://artful.jp/staging-menu/;path=/";
	let like = document.getElementsByClassName('like');
	for(let i = 0; i < like.length; i++){
		like[i].addEventListener('click', () => {
			like[i].classList.toggle('active');
		});
	}
});

