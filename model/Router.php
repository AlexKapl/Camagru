<?php

class Router
{
	private $_routes;

	public function __construct() {
		$this->_routes = include(ROOT . '/config/routes.php');
	}

	private function _getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			$uri = trim($_SERVER['REQUEST_URI'], '/');
			return ($uri ? $uri : 'camagru');
		} else
			return (FALSE);
	}

	public function route() {
		$uri = $this->_getURI();
		if ($uri) {
			echo $uri, '<hr/>';
			foreach ($this->_routes as $route) {
				$regexp = "~camagru/($route)(.*)~";
				echo $regexp, '<hr/>';
				if (preg_match($regexp, $uri)) {
					$lal = preg_replace($regexp, "$0:$1:$2", $uri);
					echo $lal, '<hr/>';
					$path = explode(':', $lal);
					// $path[0] = ROOT . "/controller/" . $path[0] . ".php";
					return ($path);
				}
			}
		}
		return NULL;
	}

	public function __destruct() {
		// TODO: Implement __destruct() method.
	}
}
