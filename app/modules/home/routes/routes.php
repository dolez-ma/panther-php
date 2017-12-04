<?php

$routes[] = array(
    'method' => 'GET|POST',
    'path'   => '/',
    'controller' => 'home',
    'action' => 'index',
);

$routes[] = array(
    'method' => 'GET|POST',
    'path'   => '/toto',
    'controller' => 'home',
    'action' => 'toto',
);

\PantherPHP\Panther\Beast::getBrain()->addRoutes('home', $routes);