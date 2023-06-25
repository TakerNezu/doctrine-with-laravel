<?php

namespace TakeruNezu\IntegratingDoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\ClearCache;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Command\ClearCache\CollectionRegionCommand as DoctrineThisCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TakeruNezu\IntegratingDoctrineWithLaravel\app\Console\Commands\Doctrine\DoctrineBaseCommand;

class CollectionRegionCommand extends DoctrineBaseCommand
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
            ->addArgument('owner-class', InputArgument::OPTIONAL, 'The owner entity name.')
            ->addArgument('association', InputArgument::OPTIONAL, 'The association collection name.')
            ->addArgument('owner-id', InputArgument::OPTIONAL, 'The owner identifier.')
            ->addOption('em', null, InputOption::VALUE_REQUIRED, 'Name of the entity manager to operate on')
            ->addOption('all', null, InputOption::VALUE_NONE, 'If defined, all entity regions will be deleted/invalidated.')
            ->addOption('flush', null, InputOption::VALUE_NONE, 'If defined, all cache entries will be flushed.');
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
