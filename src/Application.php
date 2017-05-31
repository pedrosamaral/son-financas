<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 30/05/2017
 * Time: 21:48
 */

namespace SONFin;


use Pimple\Tests\Fixtures\Service;

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

    public function addService(string $name, $service)
    {
        if (is_callable($service)){
            $this->serviceContainer->addLazy($name, $service);
        }else{
            $this->serviceContainer->add($name, $service);
        }
    }
}