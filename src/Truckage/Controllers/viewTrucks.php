<?php

namespace src\Truckage\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class viewTrucks extends BaseController
{
	public function viewTrucks(Request $request, Response $response)
	{
		// Fetching filemaker connection from container 'db'
		$fm = $this->container->get('db');
		$layout_name = "TRUCK";
		// $settings = $this->container->get('responseMessage');

		$logger = $this->container->get('logger');
		$logger->info("Truckage '/public/api/viewTrucks' route");


		$fmquery = $fm->newFindAllCommand($layout_name);
		$result = $fmquery->execute();
		

		if($fm::isError($result))
		{
			$ErrMsg = 'Error code: '.$result->getCode().' Message: '.$result->getMessage();
			echo 'Connection Failed: '.$ErrMsg;
			return $response->withJSON($result->getMessage(), $result->getCode());
		}

		$records = $result->getRecords();

		$layout_object = $fm->getLayout($layout_name);
		$field_objects = $layout_object->getFields();
		$arr2 = array();
		$arr3 = array();
		$arr4 = array();
		$i = 0;
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
				//echo  $field_name.': '.$field_value.'<br>';
			}
			$arr[$i] = array_merge($arr3,$arr2);
			$i++;
		}

		// Creating Multidimensional array.
		for ($j=0; $j < $i; $j++) { 
			$arr4[$j] = $arr[$j];
		}
		return $response->withJSON(['trucks' => $arr4], 201);
		
		
	}
}