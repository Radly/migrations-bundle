<?php

namespace RadBundle\Migrations\Event;

use Rad\DependencyInjection\Di;
use Rad\Event\EventListener;
use Rad\Routing\Router;
use RadBundle\Migrations\Command\Create;
use RadBundle\Migrations\Command\Migrate;
use RadBundle\Migrations\Command\Rollback;
use RadBundle\Migrations\Command\Status;
use Symfony\Component\Console\Application;

/**
 * Migrations Event
 *
 * @package RadBundle\Migrations\Event
 */
class MigrationsListener extends EventListener
{
    /**
     * Run console application
     *
     * @param Di $di
     *
     * @throws \Rad\DependencyInjection\Exception
     */
    public function runConsoleApplication(Di $di)
    {
        /** @var Router $router */
        $router = $di->get('router');
        if ($router->getModule() !== 'Migrations') {
            return;
        }

        if (!defined('PHINX_VERSION')) {
            define('PHINX_VERSION', (0 === strpos('@PHINX_VERSION@', '@PHINX_VERSION')) ? '0.4.1' : '@PHINX_VERSION@');
        }

        array_shift($_SERVER['argv']);
        if ($_SERVER['argv']) {
            $path = $_SERVER['argv'][0];
            unset($_SERVER['argv'][0]);
            $_SERVER['argv'] = array_merge(explode(':', $path), $_SERVER['argv']);
        }

        $app = new Application('Migrations plugin, based on Phinx by Rob Morgan.', PHINX_VERSION);
        $app->add(new Status());
        $app->add(new Create());
        $app->add(new Migrate());
        $app->add(new Rollback());
        $app->run();
    }
}
