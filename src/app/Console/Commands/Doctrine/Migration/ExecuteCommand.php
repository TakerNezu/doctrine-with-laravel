<?php

namespace TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand as DoctrineThisCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;

class ExecuteCommand extends DoctrineBaseCommand
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
            ->addArgument(
                'versions',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'The versions to execute.',
                null
            )
            ->addOption(
                'write-sql',
                null,
                InputOption::VALUE_OPTIONAL,
                'The path to output the migration SQL file. Defaults to current working directory.',
                false
            )
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_NONE,
                'Execute the migration as a dry run.'
            )
            ->addOption(
                'up',
                null,
                InputOption::VALUE_NONE,
                'Execute the migration up.'
            )
            ->addOption(
                'down',
                null,
                InputOption::VALUE_NONE,
                'Execute the migration down.'
            )
            ->addOption(
                'query-time',
                null,
                InputOption::VALUE_NONE,
                'Time all the queries individually.'
            );
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
