<?php

require_once __DIR__.'/../bootstrap.php';

$app->getEventDispatcher()->dispatchGeneralEvent('pantona.router.pre');
$app->getModuleLoader()->loadRoutes();
$app->getEventDispatcher()->dispatchGeneralEvent('pantona.router.finished');
$app->getEventDispatcher()->dispatchGeneralEvent('pantona.application.start');
$app->run();
$app->getEventDispatcher()->dispatchGeneralEvent('pantona.application.shutdown');