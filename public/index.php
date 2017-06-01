<?php

use SONFin\Application;
use SONFin\Plugins\RoutePlugin;
use SONFin\ServiceContainer;

require_once __DIR__ .'/../vendor/autoload.php';

/* Foi inicializado o container de servico */
$serviceContainer = new ServiceContainer();

/* Passou o container de servico para dentro da pasta application */
$app = new Application($serviceContainer);

/* Nesse momento plugamos a rota */
$app->plugin(new RoutePlugin());

$app->get('/', function (){
    echo "Hello World, Pedro Amaral";
});

$app->get('/home', function (){
    echo "Mostrando a Home";
});

$app->start();