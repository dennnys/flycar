document.body.onload = function() {
	setTimeout(function() {
		var preloader = document.getElementById('loader-wrapper');
		if( !preloader.classList.contains('doneloader')) {
			preloader.classList.add('doneloader');
		}
	}, 500);
}