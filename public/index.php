<?php

require_once __DIR__.'/../bootstrap.php';

$app->getEventDispatcher()->dispatchGeneralEvent('pantono.router.pre');
$app->getModuleLoader()->loadRoutes();
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.router.finished');
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.application.start');
$app->run();
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.application.shutdown');