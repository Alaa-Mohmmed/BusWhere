<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class dashController extends Controller
{
    //
    
	public function show(){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();
		$reference = $database->getReference('Student');
		$reference2 = $database->getReference('Supervisor');
		$reference3 = $database->getReference('Trip');
		$reference4 = $database->getReference('Violations');
		$Students = $reference->getValue();
		$Supervisors = $reference2->getValue();
		$Trips = $reference3->getValue();
		$Violations = $reference4->getValue();
		$Returned=array('Student'=>$Students? count($Students):0,
			'Supervisor'=>$Supervisors? count($Supervisors):0,
			'Trip'=>$Trips? count($Trips):0,
			'Violation'=>$Violations? count($Violations):0,
		);
		return ($Returned);
	}



public function getviolation(){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();
		$reference4 = $database->getReference('Violations');
		// $reference = $database->getReference('Bus');
		$Violations = $reference4->getValue();
		// $Bus = $reference->getValue();
		$BusArray=array();

		foreach ($Violations as $key=>$value) {
			$Counter=0;
			foreach ($Violations as $key1 => $value1) {
				if ($value['busName']==$value1['busName'])$Counter++;	
			}
			$BusArray[]=array('BusName'=>$value['busName'],'Counter'=>$Counter);
		}
		// $BusArrayCounter=array();
		// foreach($Bus as $key =>$value){
		// 	$BusArray[]=$value['name'];
		// 	$BusArrayCounter[]=array('BusName'=>$value['name'],'Counter'=>0);
		// }
		// foreach ($BusArray as $key=>$value) {
		// 	foreach ($Violations as $key1 => $value1) {
		// 		if ($value1['busName']==$value)$BusArrayCounter[$key]['Counter']++;	
		// 	}
		// }
		

		return array_map("unserialize", array_unique(array_map("serialize", $BusArray)));
	}
}
