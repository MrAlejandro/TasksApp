<?php

namespace AppRoutes;

use FastRoute;

function dispatch_callback($vars, $controllerName, $action)
{
    $controllerFullName = "\\App\\Controllers\\{$controllerName}";

    if (class_exists($controllerFullName, true)) {
        try {
            $container = \App\Model::getDIContainer();
            $container->set('controller', $controllerName);
            $container->set('action', $action);

            $controller = $container->get($controllerFullName);
            $controller->setControllerName($controllerName);
            $controller->setActionName($action);

            call_user_func_array([$controller, $action], $vars);

            exit;
        } catch (\DI\NotFoundException $e) {
            // TODO: implement error handling logic
        }
    } else {
        // TODO: implement 404 logic
    }
}

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function ($vars) {
        $args = [$vars, 'TaskController', 'index'];
        call_user_func_array('AppRoutes\dispatch_callback', $args);
    });

    $r->addRoute('GET', '/task/create', function ($vars) {
        $args = [$vars, 'TaskController', 'create'];
        call_user_func_array('AppRoutes\dispatch_callback', $args);
    });

    $r->addRoute('GET', '/task/edit/{id:\d+}', function ($vars) {
        $args = [$vars, 'TaskController', 'edit'];
        call_user_func_array('AppRoutes\dispatch_callback', $args);
    });

    $r->addRoute('POST', '/task/create', function ($vars) {
        $args = [$vars, 'TaskController', 'save'];
        call_user_func_array('AppRoutes\dispatch_callback', $args);
    });


    $r->addRoute('POST', '/task/update/{id:\d+}', function ($vars) {
        $args = [$vars, 'TaskController', 'update'];
        call_user_func_array('AppRoutes\dispatch_callback', $args);
    });
    /*$r->addRoute('GET', '/task/create', function () { var_dump(func_get_args());  });
    $r->addRoute('GET', '/task/{id:\d+}', function () { var_dump(func_get_args());  });*/

    /* $r->addRoute('GET', '/tasks', function () { var_dump(func_get_args()); }); */
    // {id} must be a number (\d+)
    /* $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler'); */
    // The /{title} suffix is optional
    /* $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler'); */
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (strpos('dispatch', $uri)) { // query style url
    // TODO: implement the logic
} elseif (false !== $pos = strpos($uri, '?')) { // human readable url
    // Strip query string (?foo=bar) and decode URI
    // $uri = substr($uri, 0, $pos);
    $uri = rawurldecode($uri);
}

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $handler($vars);
        // ... call $handler with $vars
        break;
}

