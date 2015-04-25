<?php

namespace Pantono\Core\Module;

use Pantono\Core\Container\Application;
use Pantono\Core\Exception\Bootstrap\Listener;
use Pantono\Core\Exception\Bootstrap\Routes;
use Pantono\Core\Model\Block;
use Pantono\Core\Model\Route;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class Loader
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var Module[]
     */
    private $modules = [];
    /**
     * @var array
     */
    private $routes = [];
    /**
     * @var array
     */
    private $controllers = [];
    /**
     * @var array
     */
    private $config = [];
    /**
     * @var array
     */
    private $eventListenerMap = [];
    /**
     * @var array
     */
    private $moduleConfig = [];

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getModule($namespace)
    {
        if (!isset($this->modules[$namespace])) {
            throw new \Exception('Trying to call module which isn\'t loaded (' . $namespace . ')');
        }
        return $this->modules[$namespace];
    }

    public function loadModule($namespace)
    {
        $module = new Module($namespace);
        $module->load();
        $this->modules[$namespace] = $module;
    }

    public function getEntityMappings()
    {
        $mappings = [];
        foreach ($this->modules as $module) {
            if ($module->getEntityMapping()) {
                $mappings[] = $module->getEntityMapping();
            }
        }
        return $mappings;
    }


    public function loadEventListeners()
    {
        foreach ($this->getModuleConfig() as $module => $config) {
            if (!empty($config['event_subscribers'])) {
                /**
                 * @var $subscriber EventSubscriberInterface
                 */
                foreach ($config['event_subscribers'] as $subscriber) {
                    $this->application->getEventManager()->addSubscriber($subscriber);
                    $events = $subscriber::getSubscribedEvents();
                    $this->eventListenerMap[$module] = $events;
                }
            }
        }
    }

    public function getCommandLineRunner()
    {
        $application = new \Symfony\Component\Console\Application();
        foreach ($this->getModuleConfig() as $config) {
            if (!empty($config['commands'])) {
                foreach ($config['commands'] as $command) {
                    $command = new $command;
                    $command->setContainer($this->application);
                    $application->add($command);
                }
            }
        }
        return $application;
    }

    public function loadDependencyInjection()
    {
        foreach ($this->getModuleConfig() as $config) {
            if (!empty($config['services'])) {
                foreach ($config['services'] as $name => $service) {
                    $this->application->addPantonoService($name, $service['class'], $service['arguments']);
                }
            }
        }
        return true;
    }

    public function getConfig()
    {
        if (!$this->config) {
            $this->loadConfig();
        }
        return $this->config;
    }

    public function getModuleConfig()
    {
        if (!$this->moduleConfig) {
            $this->loadConfig();
        }
        return $this->moduleConfig;
    }

    private function loadConfig()
    {
        $config = [];
        foreach ($this->modules as $module) {
            if ($module->getConfig()) {
                $this->moduleConfig[$module->getNamespace()] = $module->getConfig();
                $config += $module->getConfig();
            }
        }
        $this->config = $config;
    }

    public function getRoutes()
    {
        $routes = [];
        foreach ($this->modules as $module) {
            if ($module->getRoutes()) {
                $routes += $module->getRoutes();
            }
        }
        $this->routes = $routes;
        return $this->routes;
    }

    public function loadBlocks()
    {
        $config = $this->getConfig();
        $app =& $this->application;
        $blockLoader = new \Pantono\Core\Block\Loader($this->application, $this->application->getEventDispatcher());
        $blocks = isset($config['blocks']) ? $config['blocks'] : [];
        foreach ($blocks as $blockId => $options) {
            $block = new Block();
            $block->setName($blockId);
            if (!is_array($options)) {
                $block->setClassName($options);
            }

            if (is_array($options)) {
                $block->setClassName($options['className']);
                $block->setCacheable($options['cache']);
                $block->setCacheLength($options['cacheLength']);
            }
            $blockLoader->addBlock($block);
        }

        $app['Pantono.service.blocks'] = $blockLoader;

        $this->application['twig']->addFunction(new \Twig_SimpleFunction('pantono_block', function($block) use($app) {
            $args = func_get_args();
            array_shift($args);
            $content = $app->getPantonoService('blocks')->renderBlock($block, $args);
            return $content;
        }, ['is_safe' => ['html']]));
    }

    public function loadRoutes()
    {
        $routes = $this->getRoutes();
        $this->application['defined_routes'] = $routes;
        $app =& $this->application;
        foreach ($routes as $name => $route) {
            $controllerId = str_replace('\\', '.', $route['controller']);
            if (!class_exists($route['controller'])) {
                throw new Routes('Controller ' . $route['controller'] . ' for route ' . $routes['route'] . ' does not exist');
            }

            if (!method_exists($route['controller'], $route['action'])) {
                throw new Routes('Action ' . $route['action'] . ' does not exist within controller ' . $route['controller']);
            }

            if (!isset($this->controllers[$controllerId])) {
                $this->controllers[$controllerId] = true;
                $app[$controllerId] = $app->share(function () use ($app, $route) {
                    $controller = $route['controller'];
                    return new $controller($app, $route['controller'], $route['action']);
                });
            }
            if ($route['route']) {
                $app->match($route['route'], $controllerId . ':' . $route['action'])
                    ->before(function (Request $request, Application $app) use ($route) {
                        $routeModel = new Route();
                        $routeModel->setController($route['controller']);
                        $routeModel->setAction($route['action']);
                        $routeModel->setPath($route['route']);
                        $routeModel->setRequiresAdminAuth(isset($route['admin']) ? $route['admin'] : false);
                        $request->attributes->add(['pantono_route' => $routeModel]);
                        if ($route['admin']) {
                            if (!$app->getPantonoService('AdminAuthentication')->isCurrentUserAuthenticated()) {
                                return new RedirectResponse('/admin/login');
                            }
                        }
                    })
                    ->bind($name);
            }
        }
    }
}