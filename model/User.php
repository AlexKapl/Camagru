<?php

require_once(ROOT . '/model/MessageTrait.php');

class User
{
	use MessageTrait;

	private $_login;
	private $_email;
	private $_db_new_user;
	private $_db_login;
	private $_db_email;
	private $_db_link;

	public function __construct($db, $login=NULL) {
		$this->db = $db;
		$this->_login = $login;
		$this->_db_new_user = $db->prepare("INSERT INTO `user` (`login`, `email`, `password`, `link`) VALUES(?, ?, ?, ?)");
		$this->_db_login = $db->prepare("SELECT * FROM `user` WHERE `login` = ?");
		$this->_db_email = $db->prepare("SELECT * FROM `user` WHERE `email` = ?");
		$this->_db_link = $db->prepare("SELECT * FROM `user` WHERE `link` = ?");
	}

	private function _execute_query($sql, $params, $show_error) {
		$success = isset($params) ? $sql->execute($params) : $sql->execute();
		if ($success == FALSE && $show_error == TRUE) {
			$this->setError('Something went wrong, try again');
		}
		return $success;
	}

	private function _send_mail($mail_message, $mail_subject) {
		$mail_to = $this->_email;
		$from_name = 'Alexander Kaplyar';
		$from_mail = 'akaplyar@student.unit.ua';
		$encoding = "utf-8";
		$subject_preferences = [
			"input-charset" => $encoding,
			"output-charset" => $encoding,
			"line-length" => 76,
			"line-break-chars" => "\n"
		];

		$header = "Content-type: text/html; charset=" . $encoding . " \n";
		$header .= "From: " . $from_name . " <" . $from_mail . "> \n";
		$header .= "MIME-Version: 1.0 \n";
		$header .= "Content-Transfer-Encoding: 8bit \n";
		$header .= "Date: " . date("r (T)") . " \n";
		$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

		mail($mail_to, $mail_subject, $mail_message, $header);
	}

	// Checking section
	private function _check_user_login() {
		if ($this->_execute_query($this->_db_login, [$this->_login], FALSE))
			return $this->_db_login->fetch();
		else
			return FALSE;
	}

	private function _check_user_email() {
		$param = isset($this->_email) ? [$this->_email] : [$this->_login];
		if ($this->_execute_query($this->_db_email, $param, FALSE))
			return $this->_db_email->fetch();
		else
			return FALSE;
	}

	public function user_check_link($link) {
		if (isset($link)) {
			if ($this->_execute_query($this->_db_link, [$link], FALSE)) {
				return $this->_db_link->fetch();
			}
		}
		return (FALSE);
	}

	private function _check_user_password($user, $password) {
		if (password_verify(hash('whirlpool', $password), $user['password'])) {
			if ($user['status'] === '1') {
				$this->_email = $user['email'];
				return TRUE;
			} else {
				$this->setError('Please, confirm your registration!');
			}
		} else {
			$this->setError('Wrong password!');
		}
		return FALSE;
	}

	// Requests responses
	public function user_login($password) {
		if (($user = $this->_check_user_login()) !== FALSE) {
			return ($this->_check_user_password($user, $password));
		} else if (($user = $this->_check_user_email()) !== FALSE) {
			return ($this->_check_user_password($user, $password));
		} else {
			$this->setError("Login not found!");
			return FALSE;
		}
	}

	public function user_sign_up($email, $password) {
		$this->_email = $email;
		if ($this->_check_user_login())
			$this->setError('This login is already used!');
		else if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
			$this->setError('Invalid email!');
		else if ($this->_check_user_email() !== FALSE)
			$this->setError('This email is already used!');
		else {
			$password = password_hash(hash('whirlpool', $password), PASSWORD_DEFAULT);
			$link = hash('whirlpool', hash('whirlpool', $this->_email . time()));
			$args = [$this->_login, $email, $password, $link];

			if ($this->_execute_query($this->_db_new_user, $args, TRUE) === TRUE) {
				$mail_message = "Hi $this->_login!<br/>Looks like you registered on my Camagru project<br/>";
				$mail_message .= "Please, confirm your registration by clicking the link below<br/>";
				$mail_message .= BASE . "/activate/$link\n";
				$mail_subject = 'Camagru registration';
				$this->_send_mail($mail_message, $mail_subject);
				return TRUE;
			}
		}
		return FALSE;
	}

	public function user_activation($link) {
		$user = $this->user_check_link($link);
		if ($user !== FALSE) {
			if ($user['status'] === '0') {
				$update = $db->prepare("UPDATE `user` SET `status` = '1', `link` = NULL WHERE `id` = ?");
				if ($this->_execute_query($update, [$user['id']], TRUE) === TRUE)
					$this->setMessage('You successfully confirmed your registration!');
			} else
				$this->setMessage('You have already confirmed your registration!');
		} else
			$this->setError('Wrong activation link!');
	}

	public function user_password_forgot($email) {
		$this->_email = $email;
		if (($user = $this->_check_user_email()) !== FALSE) {
			$link = hash('whirlpool', hash('whirlpool', $this->_email . time()));
			$update = $db->prepare("UPDATE `user` SET `link` = ? WHERE `id` = ?");

			if ($this->_execute_query($update, [$link, $user['id']], TRUE) === TRUE) {
				$mail_message = "Hi $this->_login!<br/>Someone requested password recovery on my Camagru project.<br/>";
				$mail_message .= "If it was not you, ignore this message.<br/>";
				$mail_message .= "Otherwise to continue click the link below.<br/>";
				$mail_message .= BASE . "/recovery/$link\n";
				$mail_subject = 'Camagru password recovery';
				$this->_send_mail($mail_message, $mail_subject);

				$this->setMessage("Recovery message has been sent to your email.<br/> If it did't come, try again");
			}
		} else {
			$this->setError('Email not found!');
		}
	}

	public function user_password_recovery($password, $password2, $link) {
		$ret = FALSE;
		$redirect = TRUE;

		$user = $this->user_check_link($link);
		if ($user !== FALSE) {
			if (strcmp($password, $password2) === 0) {
				$update = $db->prepare("UPDATE `user` SET `password` = ?, `link` = NULL WHERE `id` = ?");
				$password = password_hash(hash('whirlpool', $password), PASSWORD_DEFAULT);

				if ($this->_execute_query($update, [$password, $user['id']], TRUE) === TRUE)
					$ret = TRUE;
			} else {
				$redirect = FALSE;
			}
		}
		return [$ret, $redirect];
	}
}
