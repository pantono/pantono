<?php

require_once __DIR__.'/../bootstrap.php';

$app->getEventDispatcher()->dispatchGeneralEvent('silecom.router.pre');
$app->getModuleLoader()->loadRoutes();
$app->getEventDispatcher()->dispatchGeneralEvent('silecom.router.finished');
$app->run();
$app->getEventDispatcher()->dispatchGeneralEvent('silecom.application.shutdown');