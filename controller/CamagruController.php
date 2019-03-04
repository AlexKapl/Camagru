<?php

class CamagruController extends BaseController
{

	function __construct($args)
	{
		parent::__construct($this);
	}

	public function handleRequest()
	{
		if (!isset($_SESSION['login'])) {
			header('Location: login');
			exit (0);
		}
		// else if (isset($_POST['do_login'])) {
		// 	require_once(ROOT . '/model/User.php');
		// 	$login = $_POST['login'];
		// 	$user = new User($login);

		// 	$valid = $user->check_user_login($_POST['password']);
		// 	if ($valid === TRUE) {
		// 		$_SESSION['login'] = $login;
		// 		setMessage("Welcome back, $login!");
		// 		header('Location: camagru');
		// 		exit (0);
		// 	}
		// }
	}
}
