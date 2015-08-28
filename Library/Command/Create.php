<?php

namespace Migrations\Library\Command;

use Phinx\Console\Command\Create as CreateCommand;
use Migrations\Library\ConfigurationTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Create Command
 *
 * @package Migrations\Library\Command
 */
class Create extends CreateCommand
{
    use ConfigurationTrait;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('create')
            ->setDescription('Create a new migration')
            ->addArgument('name', InputArgument::REQUIRED, 'What is the name of the migration?')
            ->setHelp(sprintf(
                '%sCreates a new database migration file%s',
                PHP_EOL,
                PHP_EOL
            ));
        $this->addOption('--bundle', '-b', InputArgument::OPTIONAL, 'The bundle the file should be created for')
            ->addOption('--template', '-t', InputOption::VALUE_REQUIRED, 'Use an alternative template')
            ->addOption(
                '--class',
                '-l',
                InputOption::VALUE_REQUIRED,
                'Use a class implementing "' . parent::CREATION_INTERFACE . '" to generate the template'
            );
    }
}
