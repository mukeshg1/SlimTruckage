<?php

// use src\Truckage\Controllers\RegisterController;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;


$app->post('/api/register', \RegisterController::class . ':userRegister');

$app->post('/api/login', \LoginController::class . ':userLogin');

$app->post('/api/viewtrucks', \viewTrucks::class . ':viewTrucks');


// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
