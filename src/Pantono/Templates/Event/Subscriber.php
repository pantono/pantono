<?php namespace Pantono\Templates\Event;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Events\General;
use Pantono\Templates\Model\Table\Table as TableModel;
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
                ['onBootstrap', 100]
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
        $this->registerTwigAssetHelper($app);
    }

    public function registerTemplatePaths($app)
    {
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => APPLICATION_BASE . '/themes/core/templates',
        ));
        $moduleTemplates = $app->getConfig()->getItem('templates', null, []);
        foreach ($moduleTemplates as $path) {
            $app['twig.loader']->addLoader(new \Twig_Loader_Filesystem(APPLICATION_BASE . '/' . $path));
        }
    }

    public function registerTableHelper($app)
    {
        $app['twig']->addFunction(new \Twig_SimpleFunction('pantono_table', function (TableModel $table) use ($app) {
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
        $dateFormat = $app->getConfig()->getItem('locale', 'dateFormat', []);
        $app['twig']->addGlobal('long_date_format', $dateFormat['long']);
        $app['twig']->addGlobal('short_date_format', $dateFormat['short']);
        $app['twig']->addGlobal('pantono_config', $app->getConfig());
        $numberFormat = $app->getConfig()->getItem('local', 'numberFormat', ['2', '.', ',']);
        $app['twig']->getExtension('core')->setNumberFormat($numberFormat[0], $numberFormat[1], $numberFormat[2]);
        $app['twig']->getExtension('core')->setDateFormat($dateFormat['short'], $dateFormat['interval']);
    }


    private function registerTwigAssetHelper(Application $app)
    {
        $app['twig'] = $app->share($app->extend('twig', function (\Twig_Environment $twig, Application $app) {
            $twig->addFunction(new \Twig_SimpleFunction('css', function ($asset) use ($app) {
                $app->getPantonoService('Css')->addFile($asset);
            }));

            $twig->addFunction(new \Twig_SimpleFunction('output_css', function () use ($app) {
                return $app->getPantonoService('Css')->getCompiled();
            }, ['is_safe' => ['html']]));

            $twig->addFunction(new \Twig_SimpleFunction('javascript', function ($asset) use ($app) {
                $app->getPantonoService('Javascript')->addFile($asset);
            }));

            $twig->addFunction(new \Twig_SimpleFunction('output_javascript', function () use ($app) {
                return $app->getPantonoService('Javascript')->getCompiled();
            }, ['is_safe' => ['html']]));

            return $twig;
        }));
    }
}
