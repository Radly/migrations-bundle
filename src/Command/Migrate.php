<?php

namespace RadBundle\Migrations\Command;

use Phinx\Console\Command\Migrate as MigrateCommand;
use RadBundle\Migrations\ConfigurationTrait;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Migrate Command
 *
 * @package RadBundle\Migrations\Command
 */
class Migrate extends MigrateCommand
{
    use ConfigurationTrait;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('migrate')
            ->setDescription('Migrate the database')
            ->addOption('--target', '-t', InputArgument::OPTIONAL, 'The version number to migrate to')
            ->setHelp('runs all available migrations, optionally up to a specific version')
            ->addOption('--bundle', '-b', InputArgument::OPTIONAL, 'The bundle containing the migrations');
    }
}
