<?php

// use src\Truckage\Controllers\RegisterController;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;


$app->post('/api/register', \RegisterController::class . ':userRegister');

$app->post('/api/login', \LoginController::class . ':userLogin');

$app->get('/api/viewTrucks', \viewTrucks::class . ':viewTrucks');

$app->get('/api/viewUserTrucks', \viewUserTrucks::class . ':viewUserTrucks');

$app->get('/api/viewTrips', \viewTrips::class . ':viewTrips');

$app->get('/api/viewDrivers', \viewDrivers::class . ':viewDrivers');


// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
