<?php

namespace RadBundle\Migrations\Command;

use Phinx\Console\Command\Rollback as RollbackCommand;
use RadBundle\Migrations\ConfigurationTrait;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Rollback Command
 *
 * @package RadBundle\Migrations\Command
 */
class Rollback extends RollbackCommand
{
    use ConfigurationTrait;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('rollback')
            ->setDescription('Rollback the last or to a specific migration')
            ->addOption('--target', '-t', InputArgument::OPTIONAL, 'The version number to rollback to')
            ->setHelp('reverts the last migration, or optionally up to a specific version')
            ->addOption('--bundle', '-b', InputArgument::OPTIONAL, 'The plugin containing the migrations');
    }
}
