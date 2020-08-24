$(() => {
	let like = document.getElementsByClassName('like');
	console.log(like);
	for(let i = 0; i < like.length; i++){
		like[i].addEventListener('click', () => {
			console.log(like[i]);
			like[i].classList.toggle('active');
		});
	}
});