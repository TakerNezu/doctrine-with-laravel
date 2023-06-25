<?php

namespace TakeruNezu\IntegratingDoctrineWithLaravel\app\Console\Commands\Doctrine\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand as DoctrineThisCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Symfony\Component\Console\Input\InputArgument;
use TakeruNezu\IntegratingDoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;

class MappingDescribeCommand extends DoctrineBaseCommand
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
            ->addArgument('entityName', InputArgument::REQUIRED, 'Full or partial name of entity');
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
