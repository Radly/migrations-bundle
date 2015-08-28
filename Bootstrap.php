<?php

namespace Migrations;

use Rad\Core\Bundle;
use Rad\Configure\Config;
use Migrations\Event\MigrationsSubscriber;

/**
 * Migrations Bootstrap
 *
 * @package Migrations
 */
class Bootstrap extends Bundle
{
    /**
     * Migrations\Bootstrap constructor
     */
    public function __construct()
    {
        Config::load(__DIR__ . DS . 'Config' . DS . 'config.php');

        $this->getEventManager()->addSubscriber(new MigrationsSubscriber());
    }
}
