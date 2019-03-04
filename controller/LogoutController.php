<?php
setMessage("Good bye, $_SESSION['login']!");
unset($_SESSION['login']);
header('Location: login');
exit (0);
