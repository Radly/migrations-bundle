<?php

namespace RadBundle\Migrations;

use Rad\Application;
use Rad\Config;
use Rad\DependencyInjection\Injectable;
use RadBundle\Migrations\Event\MigrationsListener;

/**
 * Migrations Bootstrap
 *
 * @package RadBundle\Migrations
 */
class Bootstrap extends Injectable
{
    /**
     * RadBundle\Migrations\Bootstrap constructor
     */
    public function __construct()
    {
        Config::load(__DIR__ . DS . 'Config' . DS . 'config.php');

        $this->event->get(Application::EVENT_AFTER_CLI_METHOD)
            ->attach(new MigrationsListener(), 'runConsoleApplication');
    }
}
