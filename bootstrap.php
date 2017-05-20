<?php

// autoloaders
$loader = require_once(__DIR__ . '/vendor/autoload.php');

$autoloadMap = require_once(__DIR__ . '/autoload_map.php');
$classesMap = require_once(__DIR__ . '/classes_map.php');

foreach ($autoloadMap as $namespace => $path) {
    $loader->addPsr4($namespace, __DIR__ . $path);
}

$container = App\Model::getDIContainer();
$container->set('classes_map', $classesMap);

require_once 'routes.php';
