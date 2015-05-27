<?php namespace Pantono\Templates\Event;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Events\General;
use Pantono\Templates\Model\Table\Table;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Silex\Provider\TwigServiceProvider;
use Pantono\Core\Model\Block;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantono.application.start' => [
                ['onBootstrap', 90]
            ]
        ];
    }

    public function onBootstrap(General $event)
    {
        $app = $event->getApplication();
        $this->registerTemplatePaths($app);
        $app['twig']->addExtension(new TranslationExtension($app['translator']));
        foreach ($app->getBootstrap()->getModules() as $module) {
            $blocks = $module->getConfig()->getItem('blocks', null, []);
            foreach ($blocks as $blockId => $options) {
                $block = $this->generateBlock($blockId, $options);
                $app->getPantonoService('Blocks')->addBlock($block);
            }
        }

        $this->registerPantonoBlockHelper($app);
        $this->registerPantonoAclHelper($app);
        $this->registerTwigGlobals($app);
        $this->registerTableHelper($app);
        $app->getServiceLocator()->registerAlias('twig', 'twig');
    }

    public function registerTemplatePaths($app)
    {
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => APPLICATION_BASE . '/themes/core/templates',
        ));
        $moduleTemplates = $app->getConfig()->getItem('templates', null, []);
        foreach ($moduleTemplates as $path) {
            $app['twig.loader']->addLoader(new \Twig_Loader_Filesystem(APPLICATION_BASE.'/'.$path));
        }
    }

    public function registerTableHelper($app)
    {
        $app['twig']->addFunction(new \Twig_SimpleFunction('pantono_table', function (Table $table) use ($app) {
            $content = $app->getServiceLocator()->getService('TableHelper')->renderTable($table);
            return $content;
        }, ['is_safe' => ['html']]));
    }

    /**
     * @param $app
     */
    public function registerPantonoBlockHelper($app)
    {
        $app['twig']->addFunction(new \Twig_SimpleFunction('pantono_block', function ($block) use ($app) {
            $args = func_get_args();
            array_shift($args);
            $content = $app->getServiceLocator()->getService('Blocks')->renderBlock($block, $args);
            return $content;
        }, ['is_safe' => ['html']]));
    }

    public function registerPantonoAclHelper($app)
    {
        $app['twig']->addFunction(new \Twig_SimpleFunction('is_role_allowed', function ($resource, $action, $role) use ($app) {
            return $app->getPantonoService('Acl')->isRoleAllowed($resource, $action, $role);
        }));

        $app['twig']->addFunction(new \Twig_SimpleFunction('is_allowed', function ($resource, $action) use ($app) {
            return $app->getPantonoService('Acl')->isAllowed($resource, $action);
        }, ['is_safe' => ['html']]));
    }


    /**
     * @param $blockId
     * @param $options
     * @return Block
     */
    private function generateBlock($blockId, $options)
    {
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
        return $block;
    }


    private function registerTwigGlobals(Application $app)
    {
        $app['twig']->addGlobal('long_date_format', $app->getConfig()->getItem('settings', 'long_date_format'));
        $app['twig']->addGlobal('short_date_format', $app->getConfig()->getItem('settings', 'short_date_format'));
        $app['twig']->addGlobal('pantono_config', $app->getConfig());
    }
}
