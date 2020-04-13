<?php

trait MessageTrait {

	private function setSessionMessage($type, $msg) {
		$_SESSION['Message'] = "<div class=\"$type\">$msg</div><hr/>";
	}

	public function setMessage($msg) {
		if (!empty($msg))
			$this->setSessionMessage("msg", $msg);
	}

	public function setError($msg) {
		if (!empty($msg))
			$this->setSessionMessage("error", $msg);
	}
}
