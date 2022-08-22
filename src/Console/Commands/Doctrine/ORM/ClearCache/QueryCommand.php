<?php

namespace TakeruNezu\IntegratingDoctrineWithLaravel\Console\Commands\Doctrine\ORM\ClearCache;

use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand as DoctrineThisCommand;
use TakeruNezu\IntegratingDoctrineWithLaravel\Console\Commands\Doctrine\DoctrineCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Symfony\Component\Console\Input\InputOption;

class QueryCommand extends DoctrineCommand
{
    private DoctrineThisCommand $_command;

    public function __construct(EntityManager $em)
    {
        parent::__construct();
        $this->_command = new DoctrineThisCommand(new SingleManagerProvider($em));

        $this
            ->setName('doctrine:orm:clear-cache:query')
            ->setDescription('Clear all query cache of the various cache drivers')
            ->addOption('flush', null, InputOption::VALUE_NONE, 'If defined, cache entries will be flushed instead of deleted/invalidated.')
            ->setHelp(<<<'EOT'
The <info>%command.name%</info> command is meant to clear the query cache of associated Entity Manager.
It is possible to invalidate all cache entries at once - called delete -, or flushes the cache provider
instance completely.

The execution type differ on how you execute the command.
If you want to invalidate the entries (and not delete from cache instance), this command would do the work:

<info>%command.name%</info>

Alternatively, if you want to flush the cache provider using this command:

<info>%command.name% --flush</info>

Finally, be aware that if <info>--flush</info> option is passed, not all cache providers are able to flush entries,
because of a limitation of its execution nature.
EOT
            );
    }

    public function handle()
    {
        $this->_command->initialize($this->input, $this->output);
        $this->_command->execute($this->input, $this->output);
    }
}
