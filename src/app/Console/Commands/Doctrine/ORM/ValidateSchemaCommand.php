<?php

namespace TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand as DoctrineThisCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Symfony\Component\Console\Input\InputOption;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;

class ValidateSchemaCommand extends DoctrineBaseCommand
{
    private DoctrineThisCommand $_command;

    public function __construct(EntityManager $em)
    {
        parent::__construct();
        $this->_command = new DoctrineThisCommand(new SingleManagerProvider($em));

        $this
            ->setName('doctrine:' . $this->_command->getName())
            ->setDescription($this->_command->getDescription())
            ->setHelp($this->_command->getHelp())
            ->addOption('em', null, InputOption::VALUE_REQUIRED, 'Name of the entity manager to operate on')
            ->addOption('skip-mapping', null, InputOption::VALUE_NONE, 'Skip the mapping validation check')
            ->addOption('skip-sync', null, InputOption::VALUE_NONE, 'Skip checking if the mapping is in sync with the database')
            ->addOption('skip-property-types', null, InputOption::VALUE_NONE, 'Skip checking if property types match the Doctrine types')
            ->setHelp('Validate that the mapping files are correct and in sync with the database.');
    }

    public function handle(): void
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
