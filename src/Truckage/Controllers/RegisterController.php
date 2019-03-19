<?php

namespace src\Truckage\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class RegisterController extends BaseController
{
	public function register(Request $request, Response $response)
	{
		// return 'Mukesh';
		// Fetching filemaker connection from container 'db'
		$fm = $this->container->get('db');

		// $this->logger->info("Slim-Skeleton '/' route");
		
		// Receiving values from Angular and assigning it to a variable
		$name = $request->getParsedBody()['name'];
		$usertype = $request->getParsedBody()['password'];
		$mobile = $request->getParsedBody()['confirmPassword'];
		$email = $request->getParsedBody()['email'];
		
		// if ($name != '' && $usertype != '' && $mobile != '' && $email != '')
		// {
			$fmquery = $fm->newAddCommand("User");
			$fmquery->setField("Name_xt", $name);
			$fmquery->setField("UserType_xt", $usertype);
			$fmquery->setField("Mobile_xt", $mobile);
			$fmquery->setField("Email_xt", $email);
		// }
		$result = $fmquery->execute();
		if($fm::isError($result))
		{
			$ErrMsg = 'Error code: '.$result->getCode().' Message: '.$result->getMessage();
			echo 'Connection Failed: '.$ErrMsg;
			return $response->withJSON($result->getMessage(), $result->getCode());
		}
		else
		{
			return $response->withJSON('Success', 201);
		}
		}
}