<?php namespace Pantono\Templates\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Silex\Provider\TwigServiceProvider;
use Pantono\Core\Model\Block;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Pantono\Core\Form\Extensions;

class Subscriber implements EventSubscriberInterface
{
    private $application;

    public static function getSubscribedEvents()
    {
        return [
            'pantono.bootstrap.start' => [
                ['onBootstrap', 90]
            ]
        ];
    }

    public function onBootstrap(General $event)
    {
        $app = $event->getApplication();
        $this->application = $app;
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => APPLICATION_BASE . '/themes/core/templates',
        ));
        $app['twig']->addExtension(new TranslationExtension($app['translator']));
        $app = $this->application;
        foreach ($app->getBootstrap()->getModules() as $module) {
            $blocks = $module->getConfig()->getItem('blocks', null, []);
            foreach ($blocks as $blockId => $options) {
                $block = $this->generateBlock($blockId, $options);
                $app->getPantonoService('Blocks')->addBlock($block);
            }
        }

        $this->application['twig']->addFunction(new \Twig_SimpleFunction('pantono_block', function ($block) use ($app) {
            $args = func_get_args();
            array_shift($args);
            $content = $app->getServiceLocator()->getService('Blocks')->renderBlock($block, $args);
            return $content;
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
}