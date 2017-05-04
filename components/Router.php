<?php

/**
 * Description of Router
 *
 * @author Anonimous
 */
class Router {
    private $routes;
    
    public function __construct() {
	$this->routes = include ROOT.'/conf/routes.php';
    }
    
    public function run() {
	$uri = $this->getUri();
	
	foreach ($this->routes as $key => $value) {
	    if (preg_match("~$key~", $uri)) {
		$elements = explode('/', $value);
		
		$controllerName = ucfirst(array_shift($elements).'Controller');
		$actionName = 'action'.ucfirst(array_shift($elements));
		
		$fileName = ROOT.'/controllers/'.$controllerName.'.php';
		if (file_exists($fileName)) {
		    include_once $fileName;
		}
		
		$controller = new $controllerName;
		$controller->$actionName();
	    }
	}
    }
    
    private function getUri() {
	if (!empty($_SERVER['REQUEST_URI'])) {
	    return trim($_SERVER['REQUEST_URI'], '/');
	}
    }
}
