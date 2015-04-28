<?php namespace Pantono\Database\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pantono\Core\Model\Config\Database;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

class Subscriber implements EventSubscriberInterface
{
    private $application;

    public static function getSubscribedEvents()
    {
        return [
            'pantono.bootstrap.start' => [
                ['onBootstrap', 99]
            ]
        ];
    }

    public function onBootstrap(General $event)
    {
        $this->application = $event->getApplication();
        $this->registerEntityMappings();
        $databaseConfig = new Database($this->application->getBootstrap()->getConfig()->getItem('database'));
        $this->application->register(
            new DoctrineServiceProvider(), [
                "db.options" => [
                    'dbname' => $databaseConfig->getDatabaseName(),
                    'user' => $databaseConfig->getUsername(),
                    'password' => $databaseConfig->getPassword(),
                    'host' => $databaseConfig->getHost(),
                    'driver' => $databaseConfig->getDriver(),
                ],
            ]
        );
        $this->application->getEntityManager()->getConfiguration()->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy());
    }


    private function registerEntityMappings()
    {
        $app = $this->application;
        $entityMappings = [];
        foreach ($app->getBootstrap()->getModules() as $module) {
            $mappings = $module->getEntityMapping();
            if (!empty($mappings)) {
                $entityMappings[] = $mappings;
            }
        }
        $app->register(new DoctrineOrmServiceProvider(), [
            "orm.proxies_dir" => APPLICATION_BASE . "/proxies",
            "orm.em.options" => [
                "mappings" => $entityMappings,
            ],
        ]);
    }
}