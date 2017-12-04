<?php

/**
 * @Author dolez-ma
 */

namespace PantherPHP\Panther\App;

use PantherPHP\Panther\Beast;

class Brain {

    protected $routes = null;
    protected $currentPath = null;

    public static function collectRoutes(){
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

    public function route($path = null){
        if(!$this->routes){
            return false;
        }

        if(!$path && isset($_GET['path'])){
            $path = $_GET['path'];
        }
        $this->currentPath = '/' . ltrim($path, '/');

        foreach($this->routes as $module => $routes){
            foreach($routes as $name => $data){
                if($data['path'] == $this->currentPath){
                    // Check the method allowed
                    if(in_array($_SERVER['REQUEST_METHOD'], explode('|', $data['method']))){
                        return $data + array(
                                'module' => $module,
                                'name'   => $name,
                        );
                    } else {
                        return false;
                    }
                }
            }
        }

        return false;
    }

    public function resolve($route){
        $controllerFile = Beast::getBaseFolder() . 'app/modules' . DS . $route['module'] . DS . 'controller' . DS . ucfirst($route['controller']) . '.php';
        $viewFile = Beast::getBaseFolder() . 'app/modules' . DS . $route['module'] . DS . 'view' . DS . $route['controller'] . DS . $route['action'] . '.phtml';

        if(file_exists($controllerFile)){
            require_once($controllerFile);

            // Get data
            $controllerName = ucfirst($route['controller']);
            $action         = $route['action'];
            $controller     = new $controllerName();

            // Call the action if it exists
            if(method_exists($controller, $action)){
                $controller->$action();
            } else {
                return false;
            }
        }

        if(file_exists($viewFile)){
            require_once($viewFile);
        }
        return false;
    }

}