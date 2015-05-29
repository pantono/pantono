<?php namespace Pantono\Core\Event\Subscriber;

use Pantono\Core\Event\Events\General;
use Silex\Translator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Pantono\Core\Container\Application;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class Core implements EventSubscriberInterface
{
    /**
     * @var Application
     */
    private $application;

    public static function getSubscribedEvents()
    {
        return [
            'pantono.bootstrap.start' => [
                ['onBootstrap', 100]
            ],
        ];
    }

    public function onBootstrap(General $event)
    {
        $this->application = $event->getApplication();

        $app = $event->getApplication();
        $app->getServiceLocator()->registerAlias('config', 'config');
        $app->getServiceLocator()->registerAlias('dispatcher', 'pantono.event.dispatcher');
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new ValidatorServiceProvider());
        $app->register(new FormServiceProvider());
        $this->registerTranslationServiceProvider();
        $app->getServiceLocator()->registerAlias('bootstrap', 'bootstrap');
    }

    private function registerTranslationServiceProvider()
    {
        $app = $this->getApplication();
        $app->register(new TranslationServiceProvider(), [
            'locale_fallbacks' => ['en']
        ]);

        $app['translator'] = $app->share($app->extend('translator', function(Translator $translator, Application $app) {
            $translator->addLoader('yaml', new YamlFileLoader());
            $locales = $app->getConfig()->getItem('locale', 'locales', []);
            if (empty($locales)) {
                $translator->addResource('yaml', APPLICATION_BASE . '/locales/en.yml', 'en');
                return $translator;
            }
            foreach ($locales as $language => $mappingFile) {
                $translator->addResource('yaml', APPLICATION_BASE . '/' . $mappingFile, $language);
            }
            return $translator;
        }));
    }




    /**
     * @return Application
     */
    private function getApplication()
    {
        return $this->application;
    }
}
