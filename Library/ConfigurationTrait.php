<?php

namespace Migrations\Library;

use Phinx\Config\Config;
use Rad\Core\Bundles;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Configuration Trait
 *
 * @package Migrations
 */
trait ConfigurationTrait
{
    /**
     * @var Config
     */
    protected $configuration;

    /**
     * @var ArgvInput
     */
    protected $input;

    /**
     * Overrides the original method from phinx in order to return a tailored
     * Config object containing the connection details for the database.
     *
     * @return Phinx\Config\Config
     */
    public function getConfig()
    {
        if ($this->configuration) {
            return $this->configuration;
        }

        $dir = APP_DIR . DS . 'Resource' . DS . 'migrations';
        $migrationTable = 'phinxlog';

        if ($bundleName = $this->input->getOption('bundle')) {
            $dir = Bundles::getPath($bundleName) . DS . 'Resource' . DS . 'migrations';
        }

        return $this->configuration = new Config([
            'paths' => [
                'migrations' => $dir
            ],
            'environments' => [
                'default_migration_table' => $migrationTable,
                'default_database' => getenv('RAD_ENVIRONMENT'),
                getenv('RAD_ENVIRONMENT') => \Rad\Configure\Config::get('Migrations.environments.' . getenv('RAD_ENVIRONMENT'))
            ]
        ]);
    }

    /**
     * Show the migration status.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->addOption('--environment', '-e', InputArgument::OPTIONAL);
        $input->setOption('environment', getenv('RAD_ENVIRONMENT'));
        parent::execute($input, $output);
    }
}
