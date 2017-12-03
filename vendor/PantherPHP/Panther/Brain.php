<?php

/**
 * @Author dolez-ma
 */

namespace PantherPHP\Panther;

class Brain {

    protected $url = "/";
    protected $routes = null;
    protected $method;

    protected $currentCallback;
    protected $currentParams = null;

    public function __construct()
    {
        if(isset($_GET['url'])){
            if(substr($_GET['url'], -1) === '/'){
                $_GET['url'] = substr($_GET['url'], 0, -1);
            }
            $this->url .= $_GET['url'];
        }
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * method memorize()
     *
     * Maps the callback function to each routes specified by the methods
     *
     * @param array $methods
     * @param $url_pattern
     * @param $callback
     * @return bool|Brain
     */
    public function memorize(array $methods, $url_pattern, $callback){
        // Verify if the methods specified are valid
        foreach ($methods as $method){
            if(!in_array($method, ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'])){
                return false;
            }
        }

        // Verify if the urlPattern specified is valid
        if(empty($url_pattern) || !is_string($url_pattern)){
            return false;
        }

        // Verify that the callback is really a function
        if(!is_callable($callback)){
            return false;
        }

        // If everything is ok, map the callback to each method specified
        foreach ($methods as $method){
            $this->routes[$method][$url_pattern] = $callback;
        }

        return $this;
    }

    public function resolve(){
        if($this->resolveRoute()){
            $callback = $this->currentCallback;
            $callback($this->currentParams);
        }
        else {
            echo '404: ' . $this->url;
        }
    }

    /**
     * @return bool
     */
    public function resolveRoute(){
        $callback = null;
        $params   = null;

        // Checks if the url is a litteral match
        if(isset($this->routes[$this->method][$this->url])){
            $this->currentCallback = $this->routes[$this->method][$this->url];
            return true;
        }
        // If it is not a litteral match then the route is dynamic
        else {
            // pattern example : /toto/{i:id}
            foreach ($this->routes[$this->method] as $pattern => $route){
                // Reset
                $params   = null;
                $callback = null;


                $route_parts = explode('/', $pattern); // {"", "toto", "{i:id}"}
                $url_parts   = explode('/', $this->url); // {"", "toto", "1"}
                if(count($route_parts) !== count($url_parts)){
                    continue;
                }

                foreach ($route_parts as $key => $part){
                    if(mb_strpos($part, '{') !== false){
                        $part_key = str_replace(array('{', '}'), '', $part); // $key = 2, $part_key = "i:id"
                        $params[$part_key] = $url_parts[$key]; // params: {i:id => "1"}
                        $url_parts[$key] = $part; // $url_parts[2] = "{i:id}"
                    }
                }

                if($route_parts === $url_parts){
                    $this->currentCallback = $this->routes[$this->method][$pattern];
                    return $this->checkParams($params);
                }
            }
        }

        return false;
    }

    public function checkParams($params){
        $this->currentParams = null;
        foreach ($params as $pattern => $value){
            list($type, $name) = explode(':', $pattern); // $type: i, $name: id
            switch ($type){
                case 'digit':
                    if(!ctype_digit($value) && mb_strpos($name, '@') !== false){
                        return false;
                    }
                    break;
                case 'alpha':
                    if(!ctype_alpha($value) && mb_strpos($name, '@') !== false){
                        return false;
                    }
                    break;
            }
            $name = str_replace('@', '', $name);
            $this->currentParams[$name] = $value;
        }
        return true;
    }

}