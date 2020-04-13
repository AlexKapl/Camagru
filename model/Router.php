<?php

class Router
{
	private $db;
	private $_routes;

	public function __construct($db) {
		$this->db = $db;
		$this->_routes = include_once(ROOT . '/config/routes.php');
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
			$path = ROOT . "/controller/$class.php";
			$args = $result[1];

			if (file_exists($path)) {
				require_once ($path);
				$controller = new $class($args, $this->db);
				$controller->handleRequest();
			} else {
				require_once ('404.html');
			}
		} else {
			require_once ('404.html');
		}
	}
}
