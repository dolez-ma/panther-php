<?php
/**
 * Index.php
 *
 * This file is the entry point for this framework.
 *
 * @Author: dolez-ma
 */

require(__DIR__ . '/../vendor/autoload.php');

$panther = new \PantherPHP\Panther\Beast();

require (__DIR__ . '/../app/routes/routes.php');

$panther->wakeUp();