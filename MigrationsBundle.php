<?php

namespace Migrations;

use Rad\Configure\Config;
use Rad\Core\AbstractBundle;
use Migrations\Event\MigrationsSubscriber;

/**
 * Migrations Bundle
 *
 * @package Migrations
 */
class MigrationsBundle extends AbstractBundle
{
    /**
     * {@inheritdoc}
     */
    public function startup()
    {
        $this->getEventManager()->addSubscriber(new MigrationsSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function loadConfig()
    {
        Config::load(__DIR__ . DS . 'Resource' . DS . 'config' . DS . 'config.php');
    }
}
