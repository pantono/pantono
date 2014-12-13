<?php
use \Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Csburton\SilEcom\Core\Container\Application;
use \Silex\Provider\DoctrineServiceProvider;

define('APPLICATION_BASE', __DIR__);
define('APPLICATION_PUBLIC', APPLICATION_BASE . '/public');
require_once __DIR__ . '/vendor/autoload.php';
$config = new \Csburton\SilEcom\Core\Model\Config\Config();
$config->addFile(__DIR__ . '/config/config.yml');
$app = new Application();
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
    'Suppliers'
];

$moduleLoader = new \Csburton\SilEcom\Core\Module\Loader($app);
$app['module_loader'] = $moduleLoader;
foreach ($baseModules as $module) {
    $moduleLoader->loadModule('Csburton\\SilEcom\\' . $module);
}
$moduleLoader->loadEventListeners();
$app->getEventDispatcher()->dispatchGeneralEvent('silecom.application.init');
$databaseConfig = new \Csburton\SilEcom\Core\Model\Config\Database($config->getItem('database'));
$app->register(
    new DoctrineServiceProvider, [
        "db.options" => [
            'dbname' => $databaseConfig->getDatabaseName(),
            'user' => $databaseConfig->getUsername(),
            'password' => $databaseConfig->getPassword(),
            'host' => $databaseConfig->getHost(),
            'driver' => $databaseConfig->getDriver(),
        ],
    ]
);

$app->getEventDispatcher()->dispatchGeneralEvent('silecom.bootstrap.start');
$app->getEventDispatcher()->dispatchGeneralEvent('silecom.bootstrap.end');
