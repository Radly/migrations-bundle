<?php

namespace Migrations\Library\Command;

use Phinx\Console\Command\Migrate as MigrateCommand;
use Migrations\Library\ConfigurationTrait;
use Symfony\Component\Console\Input\InputOption;

/**
 * Migrate Command
 *
 * @package Migrations\Library\Command
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
            ->addOption('--target', '-t', InputOption::VALUE_REQUIRED, 'The version number to migrate to')
            ->addOption('--date', '-d', InputOption::VALUE_REQUIRED, 'The date to migrate to')
            ->addOption('--bundle', '-b', InputOption::VALUE_OPTIONAL, 'The bundle containing the migrations')
            ->setHelp(
                <<<EOT
 The <info>migrate</info> command runs all available migrations, optionally up to a specific version

<info>migrations:migrate</info>
<info>migrations:migrate -t 20110103081132</info>
<info>migrations:migrate -d 20110103</info>
<info>migrations:migrate -v</info>

EOT
            );
    }
}
