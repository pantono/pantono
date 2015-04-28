<?php

define('BOOTSTRAP_START', microtime(true));
define('APPLICATION_BASE', __DIR__);
define('APPLICATION_PUBLIC', APPLICATION_BASE . '/public');

require_once __DIR__ . '/vendor/autoload.php';
$bootstrap = new \Pantono\Core\Bootstrap(__DIR__.'/config/config.yml');
$app = $bootstrap->boostrap($_SERVER);

$app->getEventDispatcher()->dispatchGeneralEvent('pantono.application.init');

$app->getEventDispatcher()->dispatchGeneralEvent('pantono.bootstrap.start');
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.bootstrap.end');
$app->getEntityManager()->getConfiguration()->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy());