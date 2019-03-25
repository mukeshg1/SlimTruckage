<?php

namespace src\Truckage\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use \Firebase\JWT\JWT;
use Interop\Container\ContainerInterface;

class LoginController {

	public function __construct(ContainerInterface $container){
        $this->container = $container->get('db');
        $this->settings = $container->get('settings');
    }

	public function Login($request, $response)    {

		$email = $request->getParsedBody()['username'];
	    $password = $request->getParsedBody()['password'];

		if ($email == "mindfire@email.com" && $password == "mindfire")
		{
			$token = JWT::encode(['id' => 1, 'email' => "abc"], $this->settings['jwt']['secret'], "HS256");
	    	return $response->withJSON(['token' => $token], 200);
		}
		return $response->withJSON(['error' => true, 'message' => 'Invalid Email or Password.'], 200);
	}
}