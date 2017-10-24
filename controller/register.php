<?php
require 'source/db.php';

if ( isset($_POST['register']) )
{
    if ( R::count('users', "login = ?", array($_POST['login'])) > 0 )
		echo '<div style="color: red" "; margin-left: 0px; margin:auto;>This login is already used!</div><hr/>';
    else {
        $user = R::dispense('users');
        $user->login = $_POST['login'];
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        R::store($user);
        echo '<div style="color: greenyellow" ">You registered !</div><hr/>';
        header('Location: login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
	<link rel="stylesheet" href="style.css">
</head>
    <body>
        <div class="login">
            <div class="form">
                <div class="lfield">
                    <form action="register.php" method="POST">
                        <p>
                            <input type="text" name="login" required pattern="[\w\d]{6,}" placeholder="Login(min 6)" value="<?php echo @$data['login']; ?>">
                        </p>
                        <p>
                            <input type="password" name="password" required pattern="[\w\d]{6,}" placeholder="password(min 6)" value="">
                        </p>
                        <p>
                            <button type="submit" name="register">
								Register
                            </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>