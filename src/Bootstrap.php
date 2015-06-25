<?php

namespace RadBundle\Migrations;

use Rad\Config;
use Rad\Core\Bundle;
use RadBundle\Migrations\Event\MigrationsSubscriber;

/**
 * Migrations Bootstrap
 *
 * @package RadBundle\Migrations
 */
class Bootstrap extends Bundle
{
    /**
     * RadBundle\Migrations\Bootstrap constructor
     */
    public function __construct()
    {
        Config::load(__DIR__ . DS . 'Config' . DS . 'config.php');

        $this->getEventManager()->addSubscriber(new MigrationsSubscriber());
    }
}
