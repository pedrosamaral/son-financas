<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 29/05/2017
 * Time: 23:04
 */

namespace SONFin;


interface ServiceContainerInterface
{
    //metodos
    public function add(string $name, $service);

    public function addLazy(string $name, callable $callable);

    public function get(string $name);

    public function has(string $name);

}