<?php
$_SESSION['Message'] = '<div class="msg">Good bye, ' . $_SESSION['login'] . '!</div><hr/>';
unset($_SESSION['login']);
header('Location: login');
exit (0);
