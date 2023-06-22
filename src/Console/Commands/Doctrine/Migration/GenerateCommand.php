<?php

namespace TakeruNezu\IntegratingDoctrineWithLaravel\Console\Commands\Doctrine\Migration;

use Doctrine\Migrations\Tools\Console\Command\GenerateCommand as DoctrineThisCommand;
use TakeruNezu\IntegratingDoctrineWithLaravel\Console\Commands\Doctrine\DoctrineBaseCommand;
use Doctrine\Migrations\DependencyFactory;
use Symfony\Component\Console\Input\InputOption;

class GenerateCommand extends DoctrineBaseCommand
{
    private DoctrineThisCommand $_command;

    public function __construct(DependencyFactory $dependencyFactory)
    {
        parent::__construct();
        $this->_command = new DoctrineThisCommand($dependencyFactory);

        $this
            ->setName('doctrine:' . $this->_command->getDefaultName())
            ->setDescription($this->_command->getDescription())
            ->setHelp($this->_command->getHelp())
            ->addOption(
                'namespace',
                null,
                InputOption::VALUE_REQUIRED,
                'The namespace to use for the migration (must be in the list of configured namespaces)'
            );
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
