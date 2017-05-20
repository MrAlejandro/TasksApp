<?php

// autoloaders
$loader = require_once implode(DIRECTORY_SEPARATOR, [__DIR__, 'vendor', 'autoload.php']);

$loader->addPsr4('App\\Controllers\\', __DIR__ . '/app/Controllers');

require_once 'routes.php';
