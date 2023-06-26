<?php

namespace TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand as DoctrineThisCommand;
use Symfony\Component\Console\Input\InputOption;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;


class DumpSchemaCommand extends DoctrineBaseCommand
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
            ->addOption(
                'formatted',
                null,
                InputOption::VALUE_NONE,
                'Format the generated SQL.'
            )
            ->addOption(
                'namespace',
                null,
                InputOption::VALUE_REQUIRED,
                'Namespace to use for the generated migrations (defaults to the first namespace definition).'
            )
            ->addOption(
                'filter-tables',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Filter the tables to dump via Regex.'
            )
            ->addOption(
                'line-length',
                null,
                InputOption::VALUE_OPTIONAL,
                'Max line length of unformatted lines.',
                '120'
            );
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
