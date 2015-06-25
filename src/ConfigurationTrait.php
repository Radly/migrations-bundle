<?php

namespace RadBundle\Migrations;

use Phinx\Config\Config;
use Rad\Core\Bundles;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Configuration Trait
 *
 * @package RadBundle\Migrations
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

        $dir = APP . DS . 'Resource' . DS . 'Migrations';
        $migrationTable = 'phinxlog';

        if ($bundleName = $this->input->getOption('bundle')) {
            $dir = Bundles::getPath($bundleName) . DS . 'Resource' . DS . 'Migrations';
        }

        return $this->configuration = new Config([
            'paths' => [
                'migrations' => $dir
            ],
            'environments' => [
                'default_migration_table' => $migrationTable,
                'default_database' => getenv('RAD_ENV'),
                getenv('RAD_ENV') => \Rad\Config::get('Migrations.environments.' . getenv('RAD_ENV'))
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
        $input->setOption('environment', getenv('RAD_ENV'));
        parent::execute($input, $output);
    }
}
