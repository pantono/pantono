<?php

namespace Pantona\Core\Event\Subscriber;

use Pantona\Core\Event\Events\General;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Pantona\Core\Form\Extensions;
use Silex\Provider\SessionServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class Core implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantona.bootstrap.start' => [
                ['onBootstrap']
            ],
            /*'pantona.application.start' => [
                ['onApplicationStart']
            ]*/
        ];
    }

    public function onBootstrap(General $event)
    {
        $app = $event->getApplication();
        $moduleLoader = $app->getModuleLoader();
        $app->register(new DoctrineOrmServiceProvider(), [
            "orm.proxies_dir" => APPLICATION_BASE . "/proxies",
            "orm.em.options" => [
                "mappings" => $moduleLoader->getEntityMappings(),
            ],
        ]);

        $app->register(new ServiceControllerServiceProvider());

        $app->register(new TwigServiceProvider(), array(
            'twig.path' => APPLICATION_BASE . '/themes/core/templates',
        ));


        $app->register(new ValidatorServiceProvider());
        $app->register(new FormServiceProvider());
        $app->register(new TranslationServiceProvider(), [
            'locale_fallbacks' => ['en']
        ]);
        $app['translator'] = $app->share($app->extend('translator', function ($translator, $app) {
            $translator->addLoader('yaml', new YamlFileLoader());
            $locales = $app->getConfig()->getItem('locales');
            if (empty($locales)) {
                $translator->addResource('yaml', APPLICATION_BASE . '/locales/en.yml', 'en');
                return $translator;
            }
            foreach ($locales as $language => $mappingFile) {
                $translator->addResource('yaml', APPLICATION_BASE . '/' . $mappingFile, $language);
            }
            return $translator;
        }));
        $app['twig']->addExtension(new TranslationExtension($app['translator']));
        $app['form.extensions'] = $app->share($app->extend('form.extensions', function ($extensions) use ($app) {
            $extensions[] = new Extensions($app->getModuleLoader()->getConfig());
            return $extensions;
        }));

        $app->register(new SessionServiceProvider());
    }
}