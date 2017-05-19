<?php

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '', function () { var_dump(func_get_args()); });
    $r->addRoute('GET', '/tasks', function () { var_dump(func_get_args());  });
    $r->addRoute('GET', '/task/{id:\d+}', function () { var_dump(func_get_args());  });
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
} elseif (false !== $pos = strpos($uri, '?')) { // human readble url
    // Strip query string (?foo=bar) and decode URI
    $dispatch = substr($uri, 0, $pos);
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
