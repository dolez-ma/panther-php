<?php
/**
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
$route = Panther::getBrain()->resolve();

if($route) {
    if(!Panther::getBrain()->process($route)){
        // the process has failed
        echo 'Error: Did you forget to define the controller or action?';
    }
} else {
    echo 'Error 404: Page not found';
}