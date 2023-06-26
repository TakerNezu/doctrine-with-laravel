<?php

namespace TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\RollupCommand as DoctrineThisCommand;use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;

class RollupCommand extends DoctrineBaseCommand
{
    private DoctrineThisCommand $_command;

    public function __construct(DependencyFactory $dependencyFactory)
    {
        parent::__construct();
        $this->_command = new DoctrineThisCommand($dependencyFactory);

        $this
            ->setName('doctrine:' . $this->_command->getName())
            ->setDescription($this->_command->getDescription())
            ->setHelp($this->_command->getHelp());
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
