<?php

namespace Pantono\Core\Container;

use Pantono\Core\Block\Loader;
use Pantono\Core\Bootstrap;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Event\Manager;
use Pantono\Core\Exception\Service\NotFound;
use Pantono\Core\Model\Config\Config;
use Doctrine\ORM\EntityManager;
use Pantono\Core\Service\Locator;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;

class Application extends \Silex\Application
{
    private $pantonoServices;

    public function getServices()
    {
        return $this->pantonoServices;
    }

    /**
     * @param $module - Module name
     * @params $entity - Entity Name
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($module, $entity)
    {
        $entity = 'Pantono\\' . $module . '\Entity\\' . $entity;
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
     * @return Config
     */
    public function getConfig()
    {
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
        if (!isset($this['pantono.event.dispatcher'])) {
            $this['pantono.event.dispatcher'] = new Dispatcher($this);
        }
        return $this['pantono.event.dispatcher'];
    }

    /**
     * @return \Silex\Translator
     */
    public function getTranslator()
    {
        return $this['translator'];
    }

    /**
     * @return Loader
     */
    public function getBlockLoader()
    {
        return $this['pantono.service.blocks'];
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this['session'];
    }

    /**
     * @return Bootstrap
     */
    public function getBootstrap()
    {
        return $this['bootstrap'];
    }

    public function getServiceLocator()
    {
        if (!isset($this['pantono.service.locator'])) {
            $this['pantono.service.locator'] = new Locator($this);
        }
        return $this['pantono.service.locator'];
    }

    public function getPantonoService($name)
    {
        return $this->getServiceLocator()->getService($name);
    }
}