<?php

// autoloaders
$loader = require_once(__DIR__ . '/vendor/autoload.php');

// cusctom classes mapping
$autoloadMap = require_once(__DIR__ . '/autoload_map.php');
$classesMap = require_once(__DIR__ . '/classes_map.php');

// global config
$config = require_once(__DIR__ . '/config.php');

// DI config
$diConfig = require_once(__DIR__ . '/di_config.php');

foreach ($autoloadMap as $namespace => $path) {
    $loader->addPsr4($namespace, __DIR__ . $path);
}

// DI container handling
$builder = new \DI\ContainerBuilder();
$builder->addDefinitions($diConfig);
$container = $builder->build();
$container->set('classes_map', $classesMap);
$container->set('config', $config);

$container = App\Model::setDIContainer($container);

new App\TaskRepository\TaskRepository();
die;
require_once 'routes.php';
