window.addEventListener("DOMContentLoaded", function () {
	if (navigator.getUserMedia) {
		var video = document.getElementById('video');
		var canvas = document.getElementById('canvas');
		var context = getContext('canvas');
		var snap = getContext('snap_canvas');
		var errBack = function (e) {
			console.log('An error has occurred! - ', e)
		};

		function getContext(id) {
			var canvas = document.getElementById(id);
			var context = canvas.getContext('2d');

			context.translate(canvas.width, 0);
			context.scale(-1, 1);
			return (context);
		}

		function imageUpload() {
			var xhr = new XMLHttpRequest();
			var form = new FormData();

			canvas.toBlob(function (blob) {
				form.append('snap', blob);
				xhr.open('POST', '/camera.php', true);
				xhr.onload = function () {
					console.log(this.response);
				};
				xhr.send(form);
			});

			snap.drawImage(video, 0, 0, video.width, video.height);
		}

		navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia
			|| navigator.mozGetUserMedia;
		window.URL.createObjectURL = window.URL.createObjectURL || window.URL.webkitCreateObjectURL
			|| window.URL.mozCreateObjectURL;

		navigator.getUserMedia({video: true}, function (stream) {
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}, errBack);

		document.getElementById('snap').addEventListener('click', imageUpload);

		setInterval(function () {
			context.drawImage(video, 0, 0, video.width, video.height);
		}, 0);

	}
}, false);
