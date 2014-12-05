<?php

require_once __DIR__.'/../bootstrap.php';

$app['moduleLoader']->loadRoutes();
$app['debug'] = true;
$app->run();