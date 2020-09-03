$(() => {
	var arg = new Object;
	var pair=location.search.substring(1).split('&');
	for(var i=0;pair[i];i++) {
		var kv = pair[i].split('=');
		arg[kv[0]]=kv[1];
	}
	$.cookie("id", arg['user'], {path:"/"});
	let like = document.getElementsByClassName('like');
	for(let i = 0; i < like.length; i++){
		like[i].addEventListener('click', () => {
			like[i].classList.toggle('active');
			let name = like[i].name;
			let likes = $.cookie("likes");
			let likes_sp = likes.split(';');
			let flag = false;
			for(let i = 0; i < likes_sp.length; i++){
				if(likes_sp[i] == name){
					flag = true;
					break;
				}
			}
			if(flag){
				likes_sp.splice(i, 1);
			}
			else{
				likes_sp.push(name);
			}
			likes = likes_sp.join(';');
			$.cookie("likes", likes, {path:"/"});
		});
	}
});

