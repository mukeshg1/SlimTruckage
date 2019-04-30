<?php

// use src\Truckage\Controllers\RegisterController;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;


$app->post('/api/register', \RegisterController::class . ':register');

$app->post('/api/login', \LoginController::class . ':Login');

$app->post('/api/image', function (Request $request, Response $response) {


	$data = $request->getParsedBody();
	// print_r($data);
	$files = $request->getUploadedFiles();

    $image = $files['document'];
    if ($image->getError() === UPLOAD_ERR_OK) { 
    	return 'Working';
    }
    return 'Not Working ';    
});

$app->get('/api/image/fetch', function (Request $request, Response $response){
	return 'http://localhost:8080/truck-2.jpg';
});

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
