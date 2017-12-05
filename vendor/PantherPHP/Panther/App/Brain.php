<?php

/**
 * @Author dolez-ma
 */

namespace PantherPHP\Panther\App;

use PantherPHP\Panther\Beast;

class Brain {

    protected $routes = null;
    protected $currentPath = null;

    public static function registerRoutes(){
        $folder = Beast::getFolder('app\modules') . DS . '*';
        foreach (glob($folder) as $file){
            $routerFile = $file . DS . 'routes' . DS . 'routes.php';
            if(file_exists($routerFile)){
                require_once($routerFile);
            }
        }
    }

    public function addRoutes($module = null, $routes = null){
        if(!$module || !$routes){
            return false;
        }

        foreach ($routes as $path => $route){
            $this->addRoute($module, $path, $route);
        }

        return true;
    }

    public function addRoute($module, $path, $route){
        if(!isset($this->routes[$module])){
            $this->routes[$module] = array();
        }
        $this->routes[$module][$path] = $route;
    }

    public function resolve($path = null){
        if(!$this->routes){
            return false;
        }

        if(!$path && isset($_GET['path'])){
            $path = $_GET['path'];
        }
        $this->currentPath = '/' . trim($path, '/');

        foreach($this->routes as $module => $routes){
            foreach($routes as $data){

                $params = array();

                if(!in_array($_SERVER['REQUEST_METHOD'], explode('|', $data['method']))) {
                    continue;
                }

                if($data['path'] == $this->currentPath){
                    // Direct match
                    return $data + array('module' => $module);
                } else if (strpos($data['path'], ':') !== false){
                    // have parameters
                    $pathParts = explode('/', ltrim($data['path'], '/'));

                    foreach ($pathParts as $key => $part) {
                        // Check if current part is a parameter
                        if(strpos($part, ':') !== false){
                            // Seperate the parameter
                            list($type, $name) = explode(':', $part);
                            $params[$key] = array('type' => $type, 'name' => $name);
                        } else {
                            // Not a param, so just put in the part
                            $params[$key] = $part;
                        }
                    }

                    // separate current path in equal parts to the path parts
                    $currentPathParts = explode('/', trim($this->currentPath, '/'));

                    // If the amount of parts is not the same, not the same path
                    if(count($pathParts) !== count($currentPathParts)){
                        continue;
                    }

                    // Loop through the params & match value
                    foreach ($params as $key => $param){
                        if(is_array(($param))){
                            $value = $currentPathParts[$key];

                            switch($param['type']){
                                case 'int':
                                    if(!ctype_digit($value) || $value != (int)$value ){
                                        continue(3);
                                    }
                                    break;
                                case 'alpha':
                                    if(!ctype_alpha($value) || $value != (int)$value ){
                                        continue(3);
                                    }
                                    break;
                            }
                            Beast::getParameter()->setValue($param['name'], $value);
                        }
                        else {
                            // Not a parameter, so all we need is a matching part with the currentPathParts
                            if ($param !== $currentPathParts[$key]) {
                                // Not the same, so skip it
                                continue;
                            }
                        }
                    }

                    // If we get here, the route is a match and all the params have been added to App::getParam()
                    return $data + array(
                        'module' => $module
                    );

                }
            }
        }

        return false;
    }

    public function process($route){

        // Check if there is a closure rather than a controller. If so, call it and we're done.
        if (isset($route['callback']) && is_callable($route['callback'])) {
            $route['callback']();
            return true;
        }

        $controllerFile = Beast::getBaseFolder() . 'app/modules' . DS . $route['module'] . DS . 'controller' . DS . ucfirst($route['controller']) . '.php';
        $viewFile = Beast::getBaseFolder() . 'app/modules' . DS . $route['module'] . DS . 'view' . DS . $route['controller'] . DS . $route['action'] . '.phtml';

        if(!file_exists($controllerFile)){
            return false;
        }

        require_once($controllerFile);

        // Get data
        $controllerName = ucfirst($route['controller']);
        $action         = $route['action'];
        $controller     = new $controllerName();

        // Check action for controller
        if(!method_exists($controller, $action)){
            return false;
        }

        $controller->$action();

        return true;
    }

}