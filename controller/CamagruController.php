<?php

class CamagruController extends BaseController
{

	function __construct($args, $db)
	{
		parent::__construct($this, $db);
	}

	public function handleRequest()
	{
		if (!isset($_SESSION['login'])) {
			header('Location: login');
			exit (0);
		} else {
			echo $this->view->createView();
		}
	}
}
