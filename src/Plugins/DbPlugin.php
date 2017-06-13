<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 11/06/2017
 * Time: 20:05
 */

namespace SONFin\Plugins;

use SONFin\ServiceContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
class DbPlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $container)
    {
        $capsule = new Capsule();
        $config = include __DIR__ . '/../../config/db.php';
        $capsule->addConnection(['development']);
        $capsule->bootEloquent();
    }

}