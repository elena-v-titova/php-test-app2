<?php

require_once "vendor/autoload.php";
require_once "config.php";

# Create connection to database
$dbConnection = DBConnection::getDBConnection($dbHost, $dbName, $dbUser, $dbPassword);

function defaultHandler ($dbc) {
    return [
        'template'    => 'index.phtml',
        'params' => [
            'title' => 'Товары'
        ]
    ];
};

// Route URL
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'defaultHandler');
    $r->addRoute('GET', '/index.php', 'defaultHandler');
    $r->addRoute('GET', '/create_product', 'ProductEdit::create');
    $r->addRoute('POST', '/create_product', 'ProductEdit::create');
    $r->addRoute('GET', '/list_products', 'ProductView::getAll');
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI']);

// Run action
$routeInfo = $dispatcher->dispatch($httpMethod, $uri['path']);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $tparams = $handler($dbConnection);

        include 'templates/'.$tparams['template'];
}

$dbConnection = NULL;

