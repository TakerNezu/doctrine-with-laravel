<?php

namespace TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand as DoctrineThisCommand;
use Symfony\Component\Console\Input\InputOption;use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;

class UpToDateCommand extends DoctrineBaseCommand
{
    private DoctrineThisCommand $_command;

    public function __construct(DependencyFactory $dependencyFactory)
    {
        parent::__construct();
        $this->_command = new DoctrineThisCommand($dependencyFactory);

        $this
            ->setName('doctrine:' . $this->_command->getName())
            ->setDescription($this->_command->getDescription())
            ->setHelp($this->_command->getHelp())
            ->addOption('fail-on-unregistered', 'u', InputOption::VALUE_NONE, 'Whether to fail when there are unregistered extra migrations found')
            ->addOption('list-migrations', 'l', InputOption::VALUE_NONE, 'Show a list of missing or not migrated versions.');
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
