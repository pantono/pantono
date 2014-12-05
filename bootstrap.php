<?php
use \Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Csburton\SilEcom\Core\Container\Application;
use \Silex\Provider\DoctrineServiceProvider;

define('APPLICATION_BASE', __DIR__);
define('APPLICATION_PUBLIC', APPLICATION_BASE . '/public');

require_once __DIR__ . '/vendor/autoload.php';
$config = new \Csburton\SilEcom\Core\Model\Config\Config(__DIR__ . '/config/config.yml');
$app = new Application();
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
foreach ($baseModules as $module) {
    $moduleLoader->loadModule('Csburton\\SilEcom\\' . $module);
}

$app->register(
    new DoctrineServiceProvider, [
        "db.options" => [
            'dbname' => 'silecom',
            'user' => 'silecom',
            'password' => 'silecom',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ],
    ]
);


$config = $moduleLoader->getConfig();
$app->register(new DoctrineOrmServiceProvider(), [
    "orm.proxies_dir" => __DIR__ . "/proxies",
    "orm.em.options" => [
        "mappings" => $moduleLoader->getEntityMappings(),
    ],
]);

$app['moduleLoader'] = $moduleLoader;
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/themes/core/templates',
));