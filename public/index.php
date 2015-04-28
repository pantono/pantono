<?php
require_once __DIR__ . '/../bootstrap.php';
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.application.start');
$app->run();
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.application.shutdown');