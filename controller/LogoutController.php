<?php

class LogoutController extends BaseController
{

	function __construct($args, $db)
	{
	}

	public function handleRequest()
	{
		$this->setMessage("Good bye, ".$_SESSION['login']."!");
		unset($_SESSION['login']);
		header('Location: '.BASE.'/login');
		exit (0);
	}
}
