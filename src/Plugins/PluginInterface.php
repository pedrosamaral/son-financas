<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 30/05/2017
 * Time: 23:14
 */

namespace SONFin\Plugins;


use SONFin\ServiceContainerInterface;

interface PluginInterface
{
        public function register(ServiceContainerInterface $container);
}