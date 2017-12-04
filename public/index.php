<?php
/**
 * Index.php
 *
 * This file is the entry point for this framework.
 *
 * @Author: dolez-ma
 */

/**
 * This file is the main entry. Every request gets through this file.
 * We start by bootstrapping the beast to enable all functionalities.
 */
require_once('../vendor/PantherPHP/Panther/Bootstrap.php');

use PantherPHP\Panther\Beast as Panther;

/**
 * Panther is the main entry point, offering mostly static functions
 * Start the application, this will set debug and load configuration
 */
Panther::wakeUp();

/**
 * Try to match the path to an existing route. if no path given, current $_GET value is used
 */
$route = Panther::getBrain()->route();
var_dump(Panther::getPost()->getNamespace());
var_dump(Panther::getPost()->getClassName());
var_dump(Panther::getGet()->getNamespace());
var_dump(Panther::getGet()->getClassName());
var_dump(Panther::getSession()->getNamespace());
var_dump(Panther::getSession()->getClassName());

if($route) {
    if(!Panther::getBrain()->resolve($route)){
        // Error
    }
} else {
    // 404
}