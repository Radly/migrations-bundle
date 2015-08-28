<?php

namespace Migrations\Event;

use Rad\Core\Action;
use Rad\DependencyInjection\Container;
use Rad\Events\Event;
use Rad\Events\EventManager;
use Rad\Events\EventSubscriberInterface;
use Rad\Routing\Router;
use Migrations\Library\Command\Create;
use Migrations\Library\Command\Migrate;
use Migrations\Library\Command\Rollback;
use Migrations\Library\Command\Status;
use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * Migrations Subscriber
 *
 * @package Migrations\Event
 */
class MigrationsSubscriber implements EventSubscriberInterface
{
    /**
     * Subscribe event listener
     *
     * @param EventManager $eventManager
     *
     * @return mixed
     */
    public function subscribe(EventManager $eventManager)
    {
        $eventManager->attach(Action::EVENT_BEFORE_CLI_METHOD, [$this, 'runConsoleApplication']);
    }

    /**
     * Run console application
     *
     * @param Event $event
     *
     * @throws \Rad\DependencyInjection\Exception
     */
    public function runConsoleApplication(Event $event)
    {
        /** @var Router $router */
        $router = Container::get('router');
        if ($router->getBundle() !== 'migrations') {
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

        $app = new ConsoleApplication('Migrations plugin, based on Phinx by Rob Morgan.', PHINX_VERSION);
        $app->add(new Status());
        $app->add(new Create());
        $app->add(new Migrate());
        $app->add(new Rollback());
        $app->run();
    }
}
