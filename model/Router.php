<?php

function println($msg) {
	echo $msg, "<hr/>";
}

class Router
{
	private $_routes;

	public function __construct() {
		$this->_routes = include(ROOT . '/config/routes.php');
	}

	// Messages controlling
	private function setSessionMessage($type, $msg) {
		$_SESSION['Message'] = "<div class=\"$type\">$msg</div><hr/>";
	}

	public function setMessage($msg) {
		if (!empty($msg))
			setSessionMessage("msg", $msg);
	}

	public function setError($msg) {
		if (!empty($msg))
			setSessionMessage("error", $msg);
	}

	// Routes tracing
	private function _getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			$uri = str_replace('/camagru/', '', $_SERVER['REQUEST_URI']);
			return ($uri ? $uri : 'camagru');
		} else {
			return (FALSE);
		}
	}

	private function match_route() {
		$uri = $this->_getURI();
		if ($uri) {
			foreach ($this->_routes as $route) {
				$regexp = "~($route)(.*)~";
				if (preg_match($regexp, $uri)) {
					$path = explode(':', preg_replace($regexp, "$1:$2", $uri));
					return ($path);
				}
			}
		}
		return NULL;
	}

	public function route($value='') {
		$result = $this->match_route();
		if ($result !== NULL) {
			$class = ucfirst($result[0]) . "Controller";
			$_path = ROOT . "/controller/$class.php";
			$args = $result[1];

			if (file_exists($_path)) {
				require_once ($_path);
				$controller = new $class($args);
				$controller->handleRequest();
			} else {
				require_once ('404.html');
			}
		} else {
			require_once ('404.html');
		}
	}
}
