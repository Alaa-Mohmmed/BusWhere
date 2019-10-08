<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class busController extends Controller
{
    //
    
    // public function __construct(){
    // 	this.$stationCount=0;
    // }
    public function create(Request $request){
    	$this->validate($request,[
            'name'=>'required|string|max:191',
            'supervisorName'=>'required|string|max:191',
            'supervisorPhone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();
		$BusName=$request['name'];
		$BusData=array(
			'name' => $request['name'],
			'supervisorName' => $request['supervisorName'],
			'supervisorPhone' => $request['supervisorPhone'],
		);	
		$newPost= $database
		          ->getReference('Bus/'.$BusName)
		          ->set($BusData);
		if($newPost){
			return 2	;
		}
		return 1;
	}
	public function show(){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();
		$reference = $database->getReference('Bus');
		$Buses = $reference->getValue();
		$ReturnedBuses=array();

		foreach($Buses as $key => $value ){
			$ReturnedBuses[]=array(
				"key"=>$key,
				"name"=>$value['name'],
				"supervisorName"=>$value['supervisorName'],
			    "supervisorPhone"=>$value["supervisorPhone"],
			);
		}
		return ($ReturnedBuses);


		// $value = $reference->getValue();
		// return ($value);
	}
	public function update($BusKey, Request $request){
		$this->validate($request,[
            'name'=>'required|string|max:191',
            'supervisorName'=>'required|string|max:191',
            'supervisorPhone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		$reference = $database->getReference('Bus/'.$BusKey);
		$BusData=array(
			'name' => $request['name'],
			'supervisorName' => $request['supervisorName'],
			'supervisorPhone' => $request['supervisorPhone'],
		);	
		$reference->update($BusData);
		return 8;
	}
	public function delete($BusName){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		$reference = $database->getReference('Bus/'.$BusName);
		$reference->remove();
	}

	public function createStation(Request $request , $BusKey){
    	$this->validate($request,[
            'studentName'=>'required|string|max:191',
            'studentPhone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();
		$BusData=array(
			'latitude' => 0,
			'longitude' => 0,
			'studentName' => $request['studentName'],
			'studentPhone' => $request['studentPhone'],
		);	
		$reference = $database->getReference('Bus/'.$BusKey.'/stations');
		$Stations = $reference->getValue();
		$NewCount=$Stations?count($Stations):0;
		$reference2 = $database->getReference('Bus/'.$BusKey.'/stations/'.$NewCount)->set($BusData);
		return($reference2);
		
	}
	public function showStation($BusKey){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();
		$reference = $database->getReference('Bus/'.$BusKey.'/stations');
		$Stations = $reference->getValue();
				$ReturnedStations=array();
		foreach($Stations as $key => $value ){
			$ReturnedStations[]=array(
				"key"=>$key,
				"studentName"=>$value["studentName"],
			    "studentPhone"=>$value["studentPhone"],
			);
		}
		return ($ReturnedStations);


		// $value = $reference->getValue();
		// return ($value);
	}
	public function updateStation($BusKey,$stationKey, Request $request){
		$this->validate($request,[
            'studentName'=>'required|string|max:191',
            'studentPhone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		$reference = $database->getReference('Bus/'.$BusKey.'/stations/'.$stationKey);
		$StationData=array(
			'studentName' => $request['studentName'],
			'studentPhone' => $request['studentPhone'],
		);	
		$reference->update($StationData);
		return 8;
	}
	public function deleteStation($BusKey,$stationKey){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		$reference = $database->getReference('Bus/'.$BusKey.'/stations/'.$stationKey);
		$reference->remove();
	}
}
