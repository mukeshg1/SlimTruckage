<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['db'] = function ($c) {
	$settings = $c->get('settings')['db'];

	require_once __DIR__ . '/../FileMakerCWP/FileMaker.php';

	$fm = new FileMaker();
	$fm->setProperty('database', $settings['database']);
	$fm->setProperty('hostspec', $settings['host']);
	$fm->setProperty('username', $settings['username']);
	$fm->setProperty('password', $settings['password']);
	return $fm;
};

$container['RegisterController'] = function ($c) {
	return new \src\Truckage\Controllers\RegisterController($c);
};

$container['LoginController'] = function ($c) {
    return new src\Truckage\Controllers\LoginController($c);
};
$container['LoginService'] = function ($c) {
    return new src\Truckage\Services\LoginService($c);
};