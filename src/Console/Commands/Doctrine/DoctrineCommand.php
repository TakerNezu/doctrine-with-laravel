<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\Migrations\DependencyFactory;

class DoctrineCommand extends Command
{
    private ?DependencyFactory $dependencyFactory = null;

    public function __construct(?DependencyFactory $dependencyFactory = null)
    {
        parent::__construct();

        $this->dependencyFactory = $dependencyFactory;

        $this->addOption(
            'configuration',
            null,
            InputOption::VALUE_REQUIRED,
            'The path to a migrations configuration file. <comment>[default: any of migrations.{php,xml,json,yml,yaml}]</comment>'
        );

        $this->addOption(
            'em',
            null,
            InputOption::VALUE_REQUIRED,
            'The name of the entity manager to use.'
        );

        $this->addOption(
            'conn',
            null,
            InputOption::VALUE_REQUIRED,
            'The name of the connection to use.'
        );

        if ($this->dependencyFactory !== null) {
            return;
        }

        $this->addOption(
            'db-configuration',
            null,
            InputOption::VALUE_REQUIRED,
            'The path to a database connection configuration file.',
            'migrations-db.php'
        );
    }
}