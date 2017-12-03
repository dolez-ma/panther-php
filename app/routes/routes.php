<?php

$brain = $panther->getBrain();

$brain->memorize(['GET'], '/', function ($params){
    echo '<h1>Panther PHP</h1><br /><a href="./toto/1">Toto page</a>';
});

$brain->memorize(['GET', 'POST'], '/toto/{digit:id@}', function ($params){
    echo '<h1>Toto</h1><br /><a href="/">Accueil</a>';
});

$brain->memorize(['GET', 'POST'], '/hello/{alpha:name}', function ($params){
    echo 'Hello ' . $params['name'];
});