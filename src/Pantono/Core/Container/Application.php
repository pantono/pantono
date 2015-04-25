<?php

namespace Pantono\Core\Container;

use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Event\Manager;
use Pantono\Core\Exception\Service\NotFound;
use Pantono\Core\Model\Config\Config;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;

class Application extends \Silex\Application
{
    private $pantonoServices;
    private $aliases;

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
     * @return \Pantono\Core\Module\Loader
     */
    public function getModuleLoader()
    {
        return $this['module_loader'];
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
        if (!isset($this['Pantono.event.dispatcher'])) {
            $this['Pantono.event.dispatcher'] = new Dispatcher($this);
        }
        return $this['Pantono.event.dispatcher'];
    }

    /**
     * @return \Silex\Translator
     */
    public function getTranslator()
    {
        return $this['translator'];
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this['session'];
    }

    public function getPantonoService($name)
    {
        if (strtolower($name) === 'application') {
            return $this;
        }
        if (isset($this['Pantono.service.' . $name])) {
            return $this['Pantono.service.' . $name];
        }
        if (isset($this->aliases[$name])) {
            return $this[$this->aliases[$name]];
        }

        $service = isset($this->pantonoServices[$name]) ? $this->pantonoServices[$name] : null;

        if (!$service) {
            /**
             * @todo Add proper exception for this error
             */
            throw new \Exception('Service ' . $name . ' is not registered');
        }

        $params = [];
        foreach ($service['params'] as $param) {

            $params[] = $this->generateParameter($param);
        }
        $result = call_user_func_array(
            [new \ReflectionClass($service['class']), 'newInstance'],
            $params
        );
        $this['Pantono.service.' . $name] = $result;
        return $this['Pantono.service.' . $name];
    }

    public function generateParameter($param)
    {
        if (is_array($param)) {
            if ($param[0] === 'Repository') {
                return $this->getEntityManager()->getRepository($param[1]);
            }
        }

        if (substr($param, 0, 1) === '@') {
            return $this->getPantonoService(substr($param, 1));
        }
        if (substr($param, 0, 1) === '~') {
            $class = substr($param, 1);
            return new $class;
        }
        return $param;
    }

    public function addPantonoService($name, $class, $params)
    {
        $this->pantonoServices[$name] = [
            'class' => $class,
            'params' => $params
        ];
        return true;
    }

    public function registerAlias($name, $alias)
    {
        $this->aliases[$name] = $alias;
    }
}