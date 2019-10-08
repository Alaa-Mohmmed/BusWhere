<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class driverController extends Controller
{
    //
    public function create(Request $request){
    	$this->validate($request,[
            'busName'=>'required|string|max:191',
            'name'=>'required|string|max:191',
            'phone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();
		$DriverPhone=$request['phone'];
		$DriverData=array(
			'busName' => $request['busName'],
			'name' => $request['name'],
			'phone' => $request['phone'],
		);	
		$newPost= $database
		          ->getReference('Driver/'.$DriverPhone)
		          ->set($DriverData);
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
		$reference = $database->getReference('Driver');
		$Drivers = $reference->getValue();
		$ReturnedDrivers=array();

		foreach($Drivers as $key => $value ){
			$ReturnedDrivers[]=array(
				"key"=>$key,
				"busName"=>$value['busName'],
				"name"=>$value['name'],
			    "phone"=>$value["phone"],
			);
		}
		return ($ReturnedDrivers);


		// $value = $reference->getValue();
		// return ($value);
	}
	public function update($DriverPhone,Request $request){
		$this->validate($request,[
            'busName'=>'required|string|max:191',
            'name'=>'required|string|max:191',
            'phone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		// $DriverPhone=$request['phone'];
		$reference = $database->getReference('Driver/'.$DriverPhone);
		$DriverData=array(
			'busName' => $request['busName'],
			'name' => $request['name'],
			'phone' => $request['phone'],
		);	
		$reference->update($DriverData);
		return 8;
	}
	public function delete($DriverPhone){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		// $DriverPhone=$request['phone'];
		$reference = $database->getReference('Driver/'.$DriverPhone);
		$reference->remove();
		return 7;
	}
}
