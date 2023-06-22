<?php

namespace TakeruNezu\IntegratingDoctrineWithLaravel\Console\Commands\Doctrine\ORM;

use Doctrine\ORM\Tools\Console\Command\InfoCommand as DoctrineThisCommand;
use TakeruNezu\IntegratingDoctrineWithLaravel\Console\Commands\Doctrine\DoctrineBaseCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

class InfoCommand extends DoctrineBaseCommand
{
    private DoctrineThisCommand $_command;

    public function __construct(EntityManager $em)
    {
        parent::__construct();
        $this->_command = new DoctrineThisCommand(new SingleManagerProvider($em));

        $this
            ->setName('doctrine:' . $this->_command->getDefaultName())
            ->setDescription($this->_command->getDescription())
            ->setHelp($this->_command->getHelp());
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
