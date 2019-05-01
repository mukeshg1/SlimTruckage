<?php

namespace src\Truckage\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class RegisterController extends BaseController
{
	public function userRegister(Request $request, Response $response)
	{
		// Fetching filemaker connection from container 'db'
		$fm = $this->container->get('db');
		// $settings = $this->container->get('responseMessage');

		$logger = $this->container->get('logger');
		$logger->info("Truckage '/public/api/register' route");
		
		// Receiving values from Angular and assigning it to a variable
		$firstName = $request->getParsedBody()['firstName'];
		$lastName = $request->getParsedBody()['lastName'];
		$email = $request->getParsedBody()['email'];
		$password = $request->getParsedBody()['password'];
		$confirmPassword = $request->getParsedBody()['confirmPassword'];
		$usertype = $request->getParsedBody()['userType'];
		
		if ( empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword) || empty($usertype))
		{
			return $response->withJSON(['error' => true, 'message' => 'Enter all the required fields.'], 201);
		}
		elseif ($password !== $confirmPassword) {
			return $response->withJSON(['error' => true, 'message' => 'Password and confirmPassword donot match.'], 201);
		}
		else
		{
			$fmquery = $fm->newAddCommand("User");
			$fmquery->setField("firstName_xt", $firstName);
			$fmquery->setField("lastName_xt", $lastName);
			$fmquery->setField("Email_xt", $email);
			$fmquery->setField("UserType_xt", $usertype);
		}
		$result = $fmquery->execute();
		if($fm::isError($result))
		{
			$ErrMsg = 'Error code: '.$result->getCode().' Message: '.$result->getMessage();
			echo 'Connection Failed: '.$ErrMsg;
			return $response->withJSON($result->getMessage(), $result->getCode());
		}
		else
		{
			return $response->withJSON(['error' => false, 'message' => 'Registration Successful'], 201);
		}
		}
}