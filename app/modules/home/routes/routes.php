<?php

use PantherPHP\Panther\Beast as Panther;

$routes[] = array(
    'method' => 'GET',
    'path'   => '/',
    'controller' => 'home',
    'action' => 'index',
);

$routes[] = array(
    'method' => 'GET',
    'path'   => '/toto',
    'controller' => 'home',
    'action' => 'toto',
);

$routes[] = array(
    'method' => 'GET',
    'path'   => '/post/int:id',
    'controller' => 'home',
    'action' => 'viewPost',
);

$routes[] = array(
    'method' => 'GET|POST',
    'path'   => '/post/alpha:name',
    'callback' => function() {
        echo 'Callback controller for post: ' . Panther::getParameter()->getValue('name');
    },
);

Panther::getBrain()->addRoutes('home', $routes);