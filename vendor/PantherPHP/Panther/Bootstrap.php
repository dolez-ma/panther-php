<?php

/**
 * @Author dolez-ma
 */

/**
 * define globals
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Set error reporting
 */
error_reporting(E_ALL);
ini_set('log_errors', 1);

/**
 * Register autoloader
 */
spl_autoload_register(function ($classname){
    $path = str_replace('\\', DS, $classname);
    $path = '../vendor/'. trim($path, DS) .'.php';
    $path = str_replace('/', DS, $path);

    if(file_exists($path)){
        require_once($path);
    } else {
        throw new Exception('Unable to autoload ' . $classname);
    }
});