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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SONFin\Plugins\PluginInterface;
use Zend\Diactoros\Response\SapiEmitter;

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
        //Pegar a router
        $route = $this->service('route');
        /** @var ServerRequestInterface $request**/
        $request = $this->service(RequestInterface::class);
        //Se não existir da pagina não encontrada
        if (!$route){
            echo "Page Not Found";
            exit;
        }
        //Se pegar os atributos da router e colocar na requisição
        foreach ($route->attributes as $key => $value){
            $request = $request->withAttribute($key, $value);
        }
        //Vai acessar a ação da router configurada
        $callable = $route->handler;
        //Chama essa ação
        $response = $callable($request);
        //Emitir a responta
        $this->emitResponse($response);
    }

    protected function emitResponse(ResponseInterface $response)
    {
        $emitter = new SapiEmitter();
        $emitter->emit($response);

    }
}