<?php
/**
 * Index.php
 *
 * This file is the entry point for this framework.
 *
 * @Author: dolez-ma
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require(__DIR__ . '/lib/vendor/autoload.php');

$panther = new \PantherPHP\Panther\Application();

$panther->getRouter()->map(['GET'], '/', function ($params){
    echo '<h1>Panther PHP</h1><br /><a href="./toto">Toto page</a>';
    var_dump($params);
});

$panther->getRouter()->map(['GET', 'POST'], '/toto/{i:id}', function ($params){
    echo '<h1>Toto</h1><br /><a href="./">Accueil</a>';
    var_dump($params);
});

$panther->getRouter()->map(['GET', 'POST'], '/hello/{name}', function ($params){
    echo 'Hello ' . $params['name'];
});

$panther->run();