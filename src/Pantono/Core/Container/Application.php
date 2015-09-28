<?php

namespace Pantono\Core\Container;

use Doctrine\ORM\EntityRepository;
use Pantono\Core\Block\Loader;
use Pantono\Core\Bootstrap;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Event\Manager;
use Pantono\Core\Model\Config\Config;
use Doctrine\ORM\EntityManager;
use Pantono\Core\Service\Locator;
use Silex\Translator;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Main Application Container
 *
 * @package Pantono\Core\Container
 * @author  Chris Burton <csburton@gmail.com>
 */
class Application extends \Silex\Application
{
    /**
     * @var array
     */
    private $pantonoServices = [];

    /**
     * Gets currently loaded pantono services
     *
     * @return array
     */
    public function getServices()
    {
        return $this->pantonoServices;
    }

    /**
     * Returns doctrine repository for the given module/entity pair
     *
     * @param string $module Module name
     * @param string $entity Entity Name
     *
     * @return EntityRepository
     */
    public function getRepository($module, $entity)
    {
        $entity = 'Pantono\\' . $module . '\Entity\\' . $entity;
        return $this->getEntityManager()->getRepository($entity);
    }

    /**
     * Gets current doctrine entity manager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this['orm.em'];
    }

    /**
     * Gets instance of Symfony Form Factory
     *
     * @return FormFactory
     */
    public function getFormBuilder()
    {
        return $this['form.factory'];
    }

    /**
     * Gets a form currently registered within the form builder
     *
     * @param string $name Form Name
     *
     * @return Form
     */
    public function getForm($name)
    {
        return $this->getFormBuilder()->createBuilder($name);
    }


    /**
     * Gets instance of site config model
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this['config'];
    }

    /**
     * Gets instance of Pantono event manager
     *
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
     * Gets Pantono event dispatcher
     *
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
     * Gets instance of Silex translator
     *
     * @return Translator
     */
    public function getTranslator()
    {
        return $this['translator'];
    }

    /**
     * Gets instance of Pantono block loader
     *
     * @return Loader
     */
    public function getBlockLoader()
    {
        return $this['pantono.service.blocks'];
    }

    /**
     * Gets instance of symfony session
     *
     * @return Session
     */
    public function getSession()
    {
        return $this['session'];
    }

    /**
     * Gets instance of Pantono bootstrap
     *
     * @return Bootstrap
     */
    public function getBootstrap()
    {
        return $this['bootstrap'];
    }

    /**
     * Gets instance of pantono service locator
     *
     * @return Locator
     */
    public function getServiceLocator()
    {
        if (!isset($this['pantono.service.locator'])) {
            $this['pantono.service.locator'] = new Locator($this);
        }
        return $this['pantono.service.locator'];
    }

    /**
     * Returns pantono service
     *
     * @param string $name Service Name
     *
     * @return \stdClass
     *
     * @throws \Pantono\Core\Exception\Service\NotFound
     */
    public function getPantonoService($name)
    {
        return $this->getServiceLocator()->getService($name);
    }
}
