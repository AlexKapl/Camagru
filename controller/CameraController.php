<?php

class CameraController extends BaseController
{

	function __construct($args, $db)
	{
		parent::__construct($this, $db);
	}

	public function handleRequest()
	{
		if (isset($_FILES['snap'])) {
			print_r($_FILES['snap']);
		} else {
			echo $this->view->createView();
		}
	}
}
