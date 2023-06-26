<?php

namespace TakeruNezu\DoctrineWithLaravel;

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMSetup;
use Illuminate\Support\ServiceProvider;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\CurrentCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\DiffCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\DumpSchemaCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\ExecuteCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\GenerateCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\LatestCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\ListCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\MigrateCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\RollupCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\StatusCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\SyncMetadataCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\Migration\VersionCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\ClearCache\CollectionRegionCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\ClearCache\EntityRegionCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\ClearCache\MetadataCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\ClearCache\QueryCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\ClearCache\ResultCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\CreateCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\DropCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\InfoCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\MappingDescribeCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\UpdateCommand;
use TakeruNezu\DoctrineWithLaravel\app\Console\Commands\Doctrine\ORM\ValidateSchemaCommand;

class DoctrineWithLaravelServiceProvider extends ServiceProvider
{
    /**
     * @throws ORMException
     */
    private function createEntityManager(Array $dbConfig): EntityManager {
        $metaDataMode = config('doctrine.metadata.mode');
        $path = config('doctrine.metadata.path');

        $entityManagerConfig = match ($metaDataMode) {
            'xml' => ORMSetup::createXMLMetadataConfiguration(
                [base_path() . '/resources/xml'], true, null, app('cache.psr6')
            ),
            default => ORMSetup::createAttributeMetadataConfiguration(
                [base_path() . '/app/Entities'], true, null, app('cache.psr6')
            ),
        };

        return EntityManager::create($dbConfig, $entityManagerConfig);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $host = config('database.connections.mysql.host');
        $user = config('database.connections.mysql.username');
        $password =config('database.connections.mysql.password');
        $dbname = config('database.connections.mysql.database');
        $port = config('database.connections.mysql.port');
        $unixSocket = config('database.connections.mysql.unix_socket');

        $dbConfig = [
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'dbname' => $dbname,
            'port' => $port,
            'driver' => 'pdo_mysql',
        ];
        if ($unixSocket !== '') $dbConfig['unix_socket'] = $unixSocket;

        $this->app->singleton(EntityManager::class, function() use ($dbConfig) {
            return $this->createEntityManager($dbConfig);
        });

        $this->app->singleton(DependencyFactory::class, function() use ($dbConfig) {
            $em = $this->createEntityManager($dbConfig);

//            $connection = DriverManager::getConnection($dbConfig);

            $configuration = new Configuration();

            $configuration->addMigrationsDirectory('Database\Migrations', database_path('migrations'));
            $configuration->setAllOrNothing(true);
            $configuration->setCheckDatabasePlatform(false);

            $storageConfiguration = new TableMetadataStorageConfiguration();
            $storageConfiguration->setTableName('doctrine_migration_versions');

            $configuration->setMetadataStorageConfiguration($storageConfiguration);

            return DependencyFactory::fromEntityManager(
                new ExistingConfiguration($configuration),
                new ExistingEntityManager($em)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CurrentCommand::class,
                DiffCommand::class,
                DumpSchemaCommand::class,
                ExecuteCommand::class,
                GenerateCommand::class,
                LatestCommand::class,
                ListCommand::class,
                MigrateCommand::class,
                RollupCommand::class,
                StatusCommand::class,
                SyncMetadataCommand::class,
                UpdateCommand::class,
                VersionCommand::class,
                CollectionRegionCommand::class,
                EntityRegionCommand::class,
                MetadataCommand::class,
                QueryCommand::class,
                ResultCommand::class,
                CreateCommand::class,
                DropCommand::class,
                InfoCommand::class,
                MappingDescribeCommand::class,
                UpdateCommand::class,
                ValidateSchemaCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/config/doctrine.php' => config_path('doctrine.php'),
        ], 'integrating-doctrine-with-laravel');
    }
}
