<?php

namespace Csburton\SilEcom\Core\Container;

use Csburton\SilEcom\Core\Event\Dispatcher;
use Csburton\SilEcom\Core\Event\Manager;
use Csburton\SilEcom\Core\Exception\Service\NotFound;
use Csburton\SilEcom\Core\Model\Config\Config;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;

class Application extends \Silex\Application
{
    /**
     * @param $module - Module name
     * @params $entity - Entity Name
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($module, $entity)
    {
        $entity = 'Csburton\\SilEcom\\' . $module . '\Entity\\' . $entity;
        return $this->getEntityManager()->getRepository($entity);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this['orm.em'];
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormBuilder()
    {
        return $this['form.factory'];
    }

    /**
     * @param $name - Form Name
     * @return Form
     */
    public function getForm($name)
    {
        return $this->getFormBuilder()->createBuilder($name);
    }

    /**
     * @return \Csburton\SilEcom\Core\Module\Loader
     */
    public function getModuleLoader()
    {
        return $this['module_loader'];
    }

    /**
     * @return Config
     */
    public function getConfig() {
        return $this['config'];
    }

    /**
     * @return Manager
     */
    public function getEventManager()
    {
        if (!isset($this['event.manager'])) {
            $this['event.manager'] = new Manager($this['dispatcher']);
        }
        return $this['event.manager'];
    }

    /**
     * @return Dispatcher
     */
    public function getEventDispatcher()
    {
        if (!isset($this['silecom.event.dispatcher'])) {
            $this['silecom.event.dispatcher'] = new Dispatcher($this);
        }
        return $this['silecom.event.dispatcher'];
    }

    public function getService($service)
    {
        if (!isset($this['service' . $service])) {
            $config = $this->getModuleLoader()->getConfig();
            if (!empty($config['services'])) {
                if (isset($config['services'][$service])) {
                    $class = $config['services'][$service];
                    $factory = new $class($this);
                    $this['service' . $service] = $factory->getService();
                }
            }
        }
        if (!isset($this['service' . $service])) {
            throw new NotFound('Service ' . $service . ' cannot be found');
        }
        return $this['service' . $service];
    }

    /**
     * @return \Silex\Translator
     */
    public function getTranslator()
    {
        return $this['translator'];
    }
}