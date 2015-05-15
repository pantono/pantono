<?php

require_once __DIR__ . '/../../../../bootstrap.php';

$cliApp = $app->getBootstrap()->getCommandLineRunner();
$cliApp->run();
