<?php

// use src\Truckage\Controllers\RegisterController;
use Slim\Http\Request;
use Slim\Http\Response;


$app->post('/api/register', \RegisterController::class . ':register');

$app->post('/api/login', \LoginController::class . ':Login');




// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});