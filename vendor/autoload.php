<?php
/**
 * autoload.php
 *
 * @Author dolez-ma
 */

spl_autoload_register(function ($classname){
    $class = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
    if(is_file($class)){
        require $class;
    }
});