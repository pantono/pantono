<?php namespace Pantono\Core;

use Pantono\Core\Container\Application;
use Pantono\Core\Model\Config\Config;
use Pantono\Core\Module\Module;

class Bootstrap
{
    private $configFile;
    private $config;
    /**
     * @var Application
     */
    private $application;
    private $modules;
    private $serverVariables;

    public function __construct($configFile = '')
    {
        $this->configFile = $configFile;
    }

    /**
     * @return Application
     */
    public function boostrap($serverVariables = [])
    {
        $this->serverVariables = $serverVariables;
        $application = new Application();
        $application['debug'] = true;
        $this->application = $application;
        $this->application['bootstrap'] = $this;
        $this->initDefinitions();
        $this->initLocale();
        $this->loadModules();
        return $this->application;
    }

    private function initDefinitions()
    {
        define('BOOTSTRAP_START', microtime(true));
        define('APPLICATION_BASE', realpath(__DIR__ . '/../../../'));
        define('APPLICATION_PUBLIC', realpath(APPLICATION_BASE . '/public'));
    }

    public function addModule($namespace)
    {
        $module = new Module($this->application, $namespace);
        $module->load();
        if ($module->getConfigFile() !== null) {
            $this->getConfig()->addFile($module->getConfigFile());
        }
        $this->modules[$namespace] = $module;
    }

    public function addModules($modules = [])
    {
        foreach ($modules as $namespace) {
            $this->addModule($namespace);
        }
    }

    private function loadModules()
    {
        $this->addModules($this->getConfig()->getItem('modules', null, []));
    }

    protected function initLocale()
    {
        if (php_sapi_name() == 'cli') {
            $this->application['locale'] = 'en';
            return;
        }
        $locale = locale_accept_from_http($this->serverVariables['HTTP_ACCEPT_LANGUAGE']);
        if (false !== strpos($locale, '_')) {
            $localeArray = explode('_', $locale);
            $locale = $localeArray[0];
        }
        $this->application['locale'] = $locale;

    }

    public function getConfig()
    {
        if (empty($this->config)) {
            $this->config = new Config();
            $this->config->addFile($this->configFile);
            $this->application['config'] = $this->config;
        }
        return $this->config;
    }

    /**
     * @return Module[]
     */
    public function getModules()
    {
        return $this->modules;
    }


    public function getCommandLineRunner()
    {
        $application = new \Symfony\Component\Console\Application();
        foreach ($this->getModules() as $module) {
            foreach ($module->getConfig()->getItem('commands', null, []) as $command) {
                $command = new $command;
                $command->setContainer($this->application);
                $application->add($command);
            }
        }
        return $application;
    }
}
