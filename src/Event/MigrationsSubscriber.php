<?php

namespace RadBundle\Migrations\Event;

use Rad\Application;
use Rad\DependencyInjection\Container;
use Rad\Events\Event;
use Rad\Events\EventManager;
use Rad\Events\EventSubscriberInterface;
use Rad\Routing\Router;
use RadBundle\Migrations\Command\Create;
use RadBundle\Migrations\Command\Migrate;
use RadBundle\Migrations\Command\Rollback;
use RadBundle\Migrations\Command\Status;
use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * Migrations Subscriber
 *
 * @package RadBundle\Migrations\Event
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
        $eventManager->attach(Application::EVENT_AFTER_CLI_METHOD, [$this, 'runConsoleApplication']);
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

        $app = new ConsoleApplication('Migrations plugin, based on Phinx by Rob Morgan.', PHINX_VERSION);
        $app->add(new Status());
        $app->add(new Create());
        $app->add(new Migrate());
        $app->add(new Rollback());
        $app->run();
    }
}
