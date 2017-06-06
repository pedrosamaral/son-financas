<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 30/05/2017
 * Time: 21:48
 */
declare(strict_types=1);
namespace SONFin;


use Pimple\Tests\Fixtures\Service;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use SONFin\Plugins\PluginInterface;

class Application
{
    /**
     * Application constructor.
     * @param $serviceContainer
     **/
    private $serviceContainer;

    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = new $serviceContainer;
    }

    public function service($name)
    {
        return $this->serviceContainer->get($name);
    }

    public function addService(string $name, $service): void
    {
        if (is_callable($service)){
            $this->serviceContainer->addLazy($name, $service);
        }else{
            $this->serviceContainer->add($name, $service);
        }
    }

    public function plugin(PluginInterface $plugin): void
    {
        $plugin->register($this->serviceContainer);
    }

    /**
     * @return mixed
     */
    public function get($path, $action, $name = null): Application
    {
        $routing = $this->service('routing');
        $routing->get($name, $path, $action);
        return $this;
    }

    public function start()
    {
        $route = $this->service('route');
        /** @var ServerRequestInterface $request**/
        $request = $this->service(RequestInterface::class);
        if (!$route){
            echo "Page Not Found";
            exit;
        }

        foreach ($route->attributes as $key => $value){
            $request = $request->withAttribute($key, $value);
        }
        $callable = $route->handler;
        $callable($request);
    }
}