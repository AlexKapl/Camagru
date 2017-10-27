window.addEventListener("DOMContentLoaded", function() {
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var video = document.getElementById('video');
	var mediaConfig =  { video: true };
	var URL = false;
	var errBack = function(e) {
		console.log('An error has occurred!', e)
	};

	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia(mediaConfig, function(stream) {
			URL	= window.URL.createObjectURL(stream);
			video.src = URL;
			if (!URL)
				console.log('WTF??');
			// video.play();
		}, errBack);
	}

	else if(navigator.getUserMedia) {
		navigator.getUserMedia(mediaConfig, function(stream) {
			video.src = stream;
			video.play();
		}, errBack);
	} else if(navigator.webkitGetUserMedia) {
		navigator.webkitGetUserMedia(mediaConfig, function(stream){
			video.src = window.webkitURL.createObjectURL(stream);
			video.play();
		}, errBack);
	} else if(navigator.mozGetUserMedia) {
		navigator.mozGetUserMedia(mediaConfig, function(stream){
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}, errBack);
	}

	document.getElementById('snap').addEventListener('click', function() {
		if (!URL)
			console.log('WTF??');
		context.drawImage(video, 0, 0, 640, 480);
	});
}, false);
