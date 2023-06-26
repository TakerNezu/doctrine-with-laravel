<?php

namespace TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\ClearCache;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand as DoctrineThisCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Symfony\Component\Console\Input\InputOption;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;

class MetadataCommand extends DoctrineBaseCommand
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
            ->addOption('flush', null, InputOption::VALUE_NONE, 'If defined, cache entries will be flushed instead of deleted/invalidated.');
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
