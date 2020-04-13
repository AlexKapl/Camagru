<?php

class ActivationController extends BaseController
{
	private $user;
	private $link;

	function __construct($args, $db)
	{
		require_once(ROOT . '/model/User.php');
		$this->user = new User($db);
		$this->link = $args[0];
	}

	public function handleRequest()
	{
		$this->user->user_activation($this->link);
		header('Location: '.BASE.'/login');
	}
}
