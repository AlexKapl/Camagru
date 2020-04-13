window.addEventListener("DOMContentLoaded", function () {
	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
	// window.URL.createObjectURL = window.URL.createObjectURL || window.URL.webkitCreateObjectURL || window.URL.mozCreateObjectURL;
	window.URL = window.URL || window.webkitURL;

	function getContext(id) {
		var canvas = document.getElementById(id);
		var context = canvas.getContext('2d');

		context.translate(canvas.width, 0);
		context.scale(-1, 1);
		return (context);
	}

	function imageUpload(canvas, snap) {
		var xhr = new XMLHttpRequest();
		var form = new FormData();

		canvas.toBlob(function (blob) {
			form.append('snap', blob);
			xhr.open('POST', 'camagru/camera.php', true);
			xhr.onload = function () {
				console.log(this.response);
			};
			xhr.send(form);
		});

		snap.drawImage(video, 0, 0, video.width, video.height);
	}

	if (navigator.getUserMedia) {
		var video = document.getElementById('video');
		var canvas = document.getElementById('canvas');
		var context = getContext('canvas');
		var snap = getContext('snap_canvas');

		function setupVideo(stream) {
			try {
				video.srcObject = stream;
			} catch (error) {
				video.src = window.URL.createObjectURL(stream);
			}
			// video.src = window.URL.createObjectURL(stream);
			// video.srcObject = stream;
			video.play();
		};
		function errBack(e) {
			console.log('An error has occurred! - ', e)
		};

		navigator.getUserMedia({video: true}, setupVideo, errBack);

		document.getElementById('snap').addEventListener('click', function() {
			imageUpload(canvas, snap);
		});

		setInterval(function () {
			context.drawImage(video, 0, 0, video.width, video.height);
		}, 0);
	}

}, false);
