<?php

use Zend\Diactoros\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
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

$app->get('/', function (RequestInterface $request){
    var_dump($request->getUri());die();
    echo "Hello World, Pedro Amaral";
});
/**
 * @param ServerRequestInterface $request
 */
$app->get('/home/{name}/{id}', function (ServerRequestInterface $request){
    $response = new Response();
    $response->getBody()->write("Response com emmiter do diactoros");
    return $response;
});

$app->start();