<?php

namespace TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand as DoctrineThisCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Symfony\Component\Console\Input\InputOption;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;

class DropCommand extends DoctrineBaseCommand
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
            ->addOption('dump-sql', null, InputOption::VALUE_NONE, 'Instead of trying to apply generated SQLs into EntityManager Storage Connection, output them.')
            ->addOption('force', 'f', InputOption::VALUE_NONE, "Don't ask for the deletion of the database, but force the operation to run.")
            ->addOption('full-database', null, InputOption::VALUE_NONE, 'Instead of using the Class Metadata to detect the database table schema, drop ALL assets that the database contains.');
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
