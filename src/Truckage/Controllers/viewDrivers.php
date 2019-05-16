<?php

namespace src\Truckage\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class viewDrivers extends BaseController
{
	public function viewDrivers(Request $request, Response $response)
	{
		// return $response->withJSON(['message'=>'test']);
		$fm = $this->container->get('db');
		$layout_name = "Driver";
		// $settings = $this->container->get('responseMessage');

		$logger = $this->container->get('logger');
		$logger->info("Truckage '/public/api/viewDrivers' route");


		$fmquery = $fm->newFindAllCommand($layout_name);
		$result = $fmquery->execute();
		

		if($fm::isError($result))
		{
			return $response->withJSON(['error' => true, 'message' => $result->getMessage()], $result->getCode());
		}

		$records = $result->getRecords();

		$layout_object = $fm->getLayout($layout_name);
		$field_objects = $layout_object->getFields();
		$arr2 = array();
		$arr3 = array();
		$arr4 = array();
		$arrayCounter1 = 0;
	    foreach ($records as $record)
	    {
	    	$recid = $record->getRecordId();
	    	foreach ($field_objects as $field_object) 
	    	{
				$record = $fm->getRecordById($layout_name, $recid);
				$field_name = $field_object->getName();
				$field_value = $record->getField($field_name);
				$field_value = htmlspecialchars($field_value);
				$field_value = nl2br($field_value);
				$arr1 = array($field_name=>$field_value);
				$arr2 = array_merge($arr2,$arr1);
			}
			$arr[$arrayCounter1] = array_merge($arr3,$arr2);
			$arrayCounter1++;
		}

		// Multidimensional array creation.
		for ($arrayCounter2=0; $arrayCounter2 < $arrayCounter1; $arrayCounter2++) 
		{ 
			$arr4[$arrayCounter2] = $arr[$arrayCounter2];
		}
		return $response->withJSON(['error' => false, 'drivers' => $arr4], 201);
		
		
	}
}