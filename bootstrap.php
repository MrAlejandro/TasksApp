<?php

// autoloaders
$loader = require_once implode(DIRECTORY_SEPARATOR, [__DIR__, 'vendor', 'autoload.php']);
$loader->addPsr4('App\\', __DIR__ . '/app');
$loader->addPsr4('App\\Controllers\\', __DIR__ . '/app/Controllers');

// DI handling
/* $container = DI\ContainerBuilder::buildDevContainer(); */
/* var_dump(App\Model::getDIContainer()); */
/* die; */

require_once 'routes.php';
