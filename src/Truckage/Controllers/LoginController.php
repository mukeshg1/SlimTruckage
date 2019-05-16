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

	public function userLogin($request, $response)    {

		$email = $request->getParsedBody()['username'];
	    $password = $request->getParsedBody()['password'];

	    if (empty($email) or empty($password)) {
	    	return $response->withJSON(['error' => true, 'message' => 'Enter your Email or Password.'], 200);
	    }
	    elseif ($email == "mindfire@email.com" && $password == "mindfire@123") {
	     	$token = JWT::encode(['id' => 1, 'email' => "abc"], $this->settings['jwt']['secret'], "HS256");
	    	return $response->withJSON(['token' => $token], 200);
	     } 
		else {
			return $response->withJSON(['error' => true, 'message' => 'Invalid Email or Password.'], 200);
		}
	}
}