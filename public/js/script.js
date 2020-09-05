$(() => {
	var arg = new Object;
	var pair=location.search.substring(1).split('&');
	for(var i=0;pair[i];i++) {
		var kv = pair[i].split('=');
		arg[kv[0]]=kv[1];
	}
	$.cookie("id", arg['user'], {path:"/"});

	let l_cookie = $.cookie("like");
	if(l_cookie != undefined){
		let l_cookie_sp = l_cookie.split(',');
		l_cookie_sp.pop();
		for(let i = 0; i < l_cookie_sp.length; i++){
			let like = document.getElementById(l_cookie_sp[i]);
			like.classList.add('active');
		}
	}

	//like付け消し処理
	let like = document.getElementsByClassName('like');
	for(let i = 0; i < like.length; i++){
		like[i].addEventListener('click', () => {
			let l_cookie = $.cookie("like");
			like[i].classList.toggle('active');
			let l_id = like[i].id;	
			if(like[i].classList.contains('active')){
				if(l_cookie == undefined || l_cookie == ""){
					$.cookie("like", l_id + ",", {expires: 0.5, path:"/"});
				}
				else{
					let l_cookie_sp = l_cookie.split(',');
					l_cookie_sp.pop();
					l_cookie_sp.push(l_id);
					l_cookie = l_cookie_sp.join(',');
					$.cookie("like", l_cookie + ",", {expires: 0.5, path:"/"});
				}
			}
			else{
				try{
					let l_cookie_sp = l_cookie.split(',');
					l_cookie_sp.pop();
					for(let ci = 0; ci < l_cookie_sp.length; ci++){
						if(l_cookie_sp[ci] == l_id){
							l_cookie_sp.splice(ci, 1);
							break;
						}
					}
					l_cookie = l_cookie_sp.join(',');
				}
				catch(e){
					$.cookie("like", "", {expires: 0, path:"/"});
				}
				if(l_cookie != ""){
					$.cookie("like", l_cookie + ",", {expires: 0.5, path:"/"});
				}
				else{
					$.cookie("like", "", {expires: 0.5, path:"/"});
				}
			}
			//$.cookie("likes", likes, {path:"/"});
			console.log(document.cookie);
		});
	}
});