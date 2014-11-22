<?php
use \Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use \Silex\Application;
use \Silex\Provider\DoctrineServiceProvider;

require_once __DIR__ . '/vendor/autoload.php';
$app = new Application();
$loadedModules = [
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
$app->register(
  new DoctrineServiceProvider, [
    "db.options" => [
      'dbname'   => 'silecom',
      'user'     => 'silecom',
      'password' => 'silecom',
      'host'     => 'localhost',
      'driver'   => 'pdo_mysql',
    ],
  ]
);

$entityMappings = [];
foreach ($loadedModules as $module) {
    $entityMappings[] = [
      'type'      => 'annotation',
      'namespace' => 'SilEcom\\' . $module . '\\Entity',
      'path'      => __DIR__ . '/src/SilEcom/' . $module . '/Entity'
    ];
}

$app->register(new DoctrineOrmServiceProvider(), [
  "orm.proxies_dir" => __DIR__ . "/proxies",
  "orm.em.options"  => [
    "mappings" => $entityMappings,
  ],
]);
