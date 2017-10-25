<?php
require_once(ROOT . '/model/User.php');
$user = new User(NULL, $db);
$_SESSION['Message'] = $user->check_user_activation($args);
header('Location: http://localhost:8080/login');
