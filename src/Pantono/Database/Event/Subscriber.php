<?php namespace Pantono\Database\Event;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Events\General;
use Pantono\Database\Model\EntityMapping;
use Pantono\Database\Model\FieldMapping;
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
                ['onBootstrap', 99],
                ['registerFormMappings', 50]
            ]
        ];
    }

    public function onBootstrap(General $event)
    {
        $this->application = $event->getApplication();
        $this->registerEntityMappings();
        $databaseConfig = new Database($this->application->getBootstrap()->getConfig()->getItem('database'));
        $this->getApplication()->register(
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
        $this->getApplication()->getEntityManager()->getConfiguration()->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy());
        $this->getApplication()->getServiceLocator()->registerAlias('EntityManager', 'orm.em');
    }


    private function registerEntityMappings()
    {
        $app = $this->getApplication();
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

    public function registerFormMappings(General $event)
    {
        $this->application = $event->getApplication();
        $app = $this->getApplication();
        $mappings = $app->getConfig()->getItem('entity_mapping');
        foreach ($mappings as $name => $mapping) {
            $entityMapping = new EntityMapping();
            $entityMapping->setEntities($mapping['entities']);
            $entityMapping->setName($name);
            foreach ($mapping['mapping'] as $fieldName => $field) {
                $entityFieldMapping = new FieldMapping();
                $entityFieldMapping->setName($fieldName);
                $fieldName = isset($field['field'])?$field['field']:$fieldName;
                $entityFieldMapping->setSourceField($fieldName);
                $entityFieldMapping->setTargetField($field['mapping']);
                $entityMapping->addField($entityFieldMapping);
            }
            $app->getPantonoService('EntityMapper')->addMapping($entityMapping);
        }
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }
}
