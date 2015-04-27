<?php

define('BOOTSTRAP_START', microtime(true));
define('APPLICATION_BASE', __DIR__);
define('APPLICATION_PUBLIC', APPLICATION_BASE . '/public');

require_once __DIR__ . '/vendor/autoload.php';
$config = new \Pantono\Core\Model\Config\Config();
$config->addFile(__DIR__ . '/config/config.yml');
$app = new \Pantono\Core\Container\Application();
if (php_sapi_name() == 'cli') {
    $app['locale'] = 'en';
} else {
    $locale = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    if (false !== strpos($locale, '_')) {
        list($locale, $subLocale) = explode('_', $locale);
    }
    $app['locale'] = $locale;
}
$app['debug'] = $config->getItem('debug');
$app['config'] = $config;
$baseModules = [
    'Acl',
    'Assets',
    'Cart',
    'Categories',
    'Contacts',
    'Core',
    'Customers',
    'Email',
    'Orders',
    'Pages',
    'Payments',
    'Products',
    'Suppliers',
    'Admin'
];

$moduleLoader = new \Pantono\Core\Module\Loader($app);
$app['module_loader'] = $moduleLoader;
foreach ($baseModules as $module) {
    $moduleLoader->loadModule('Pantono\\' . $module);
}
$moduleLoader->loadEventListeners();
$moduleLoader->loadDependencyInjection();
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.application.init');
$databaseConfig = new \Pantono\Core\Model\Config\Database($config->getItem('database'));
$app->register(
    new Silex\Provider\DoctrineServiceProvider(), [
        "db.options" => [
            'dbname' => $databaseConfig->getDatabaseName(),
            'user' => $databaseConfig->getUsername(),
            'password' => $databaseConfig->getPassword(),
            'host' => $databaseConfig->getHost(),
            'driver' => $databaseConfig->getDriver(),
        ],
    ]
);
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.bootstrap.start');
$app->getEventDispatcher()->dispatchGeneralEvent('pantono.bootstrap.end');
$app->getEntityManager()->getConfiguration()->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy());