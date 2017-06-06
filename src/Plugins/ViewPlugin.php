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


class ViewPlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $container)
    {
        $container->addLazy('twig', function (ContainerInterface $container)
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../templates');
            $twig= new \Twig_Environment($loader);
            return $twig;
        });
    }

}