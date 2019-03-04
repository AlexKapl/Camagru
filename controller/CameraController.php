<?php
if (isset($_FILES['snap'])) {
	print_r($_FILES['snap']);
} else {
	require(ROOT . '/view/camera.html');
	$_SESSION['Message'] = NULL;
}
