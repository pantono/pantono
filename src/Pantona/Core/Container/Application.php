<?php

namespace Pantona\Core\Container;

use Pantona\Core\Event\Dispatcher;
use Pantona\Core\Event\Manager;
use Pantona\Core\Exception\Service\NotFound;
use Pantona\Core\Model\Config\Config;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;

class Application extends \Silex\Application
{
    private $pantonaServices;

    /**
     * @param $module - Module name
     * @params $entity - Entity Name
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($module, $entity)
    {
        $entity = 'Pantona\\' . $module . '\Entity\\' . $entity;
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
     * @return \Pantona\Core\Module\Loader
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
        if (!isset($this['pantona.event.dispatcher'])) {
            $this['pantona.event.dispatcher'] = new Dispatcher($this);
        }
        return $this['pantona.event.dispatcher'];
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

    public function getPantonaService($name)
    {
        if (strtolower($name) === 'application') {
            return $this;
        }
        if (isset($this['pantona.service.' . $name])) {
            return $this['pantona.service.' . $name];
        }

        $service = isset($this->pantonaServices[$name]) ? $this->pantonaServices[$name] : null;

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
        $this['pantona.service.' . $name] = $result;
        return $this['pantona.service.' . $name];
    }

    public function generateParameter($param)
    {
        if (is_array($param)) {
            if ($param[0] == 'Repository') {
                return $this->getEntityManager()->getRepository($param[1]);
            }
        }

        if (substr($param, 0, 1) == '@') {
            return $this->getPantonaService(substr($param, 1));
        }
        if (substr($param, 0, 1) == '~') {
            $class = substr($param, 1);
            return new $class;
        }
        return $param;
    }

    public function addPantonaService($name, $class, $params)
    {
        $this->pantonaServices[$name] = [
            'class' => $class,
            'params' => $params
        ];
        return true;
    }
}