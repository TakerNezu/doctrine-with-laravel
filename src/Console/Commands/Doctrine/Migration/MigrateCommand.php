<?php

namespace TakeruNezu\IntegratingDoctrineWithLaravel\Console\Commands\Doctrine\Migration;

use Doctrine\Migrations\Tools\Console\Command\MigrateCommand as DoctrineThisCommand;
use App\Console\Commands\DoctrineCommand;
use Doctrine\Migrations\DependencyFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrateCommand extends DoctrineCommand
{
    private DoctrineThisCommand $_command;

    public function __construct(DependencyFactory $dependencyFactory)
    {
        parent::__construct();
        $this->_command = new DoctrineThisCommand($dependencyFactory);

        $this
            ->setName('doctrine:' . $this->_command->getDefaultName())
            ->setDescription($this->_command->getDescription())
            ->addArgument(
                'version',
                InputArgument::OPTIONAL,
                'The version FQCN or alias (first, prev, next, latest) to migrate to.',
                'latest'
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
                'query-time',
                null,
                InputOption::VALUE_NONE,
                'Time all the queries individually.'
            )
            ->addOption(
                'allow-no-migration',
                null,
                InputOption::VALUE_NONE,
                'Do not throw an exception if no migration is available.'
            )
            ->addOption(
                'all-or-nothing',
                null,
                InputOption::VALUE_OPTIONAL,
                'Wrap the entire migration in a transaction.'
            )
            ->setHelp(<<<EOT
The <info>%command.name%</info> command executes a migration to a specified version or the latest available version:

    <info>%command.full_name%</info>

You can show more information about the process by increasing the verbosity level. To see the
executed queries, set the level to debug with <comment>-vv</comment>:

    <info>%command.full_name% -vv</info>

You can optionally manually specify the version you wish to migrate to:

    <info>%command.full_name% FQCN</info>

You can specify the version you wish to migrate to using an alias:

    <info>%command.full_name% prev</info>
    <info>These alias are defined : first, latest, prev, current and next</info>

You can specify the version you wish to migrate to using an number against the current version:

    <info>%command.full_name% current+3</info>

You can also execute the migration as a <comment>--dry-run</comment>:

    <info>%command.full_name% FQCN --dry-run</info>

You can output the prepared SQL statements to a file with <comment>--write-sql</comment>:

    <info>%command.full_name% FQCN --write-sql</info>

Or you can also execute the migration without a warning message which you need to interact with:

    <info>%command.full_name% --no-interaction</info>

You can also time all the different queries if you wanna know which one is taking so long:

    <info>%command.full_name% --query-time</info>

Use the --all-or-nothing option to wrap the entire migration in a transaction.
EOT
            );
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}