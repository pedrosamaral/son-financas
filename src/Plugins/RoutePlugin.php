<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 31/05/2017
 * Time: 20:55
 */

namespace SONFin\Plugins;

use Aura\Router\RouterContainer;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use SONFin\ServiceContainerInterface;
use Zend\Diactoros\ServerRequestFactory;


class RoutePlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $container)
    {
        $routerContainer = new RouterContainer();
        /* Registrar as rotas da aplicacao */
        $map = $routerContainer->getMap();
        /* Tem a funcao de identificar a rota que esta sendo acessada */
        $matcher = $routerContainer->getMatcher();
        /* Tem a funcao de gerar links com base nas rotas registradas */
        $generator = $routerContainer->getGenerator();
        $request = $this->getRequest();

        $container->add('routing', $map);
        $container->add('routing.matcher', $matcher);
        $container->add('routing.generator', $generator);
        $container->add(RequestInterface::class,$request);

        /* So e carregado quando e chamado  */
        $container->addLazy('route', function (ContainerInterface $container){
            $matcher = $container->get('routing.matcher');
            $request = $container->get(RequestInterface::class);
            return $matcher->match($request);
        });

    }

    protected function getRequest(): RequestInterface
    {
        return ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    }
}