<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class supervisorController extends Controller
{
    //
    public function create(Request $request){
    	$this->validate($request,[
            'name'=>'required|string|max:191',
            'busName'=>'required|string|max:191',
            'email'=>'required|string|email|max:191',
            'phone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();
		$SupervisorEmailKey= str_replace('.', '', $request['email']);
		$SupervisorData=array(
		  	'busName' => $request['busName'],
		  	'email' => $request['email'],
		  	'name' => $request['name'],
		  	'password' => '123456789',
		  	'phone' => $request['phone'],
		);	
		$newPost= $database
		          ->getReference('Supervisor/'.$SupervisorEmailKey)
		          ->set($SupervisorData);
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
		$reference = $database->getReference('Supervisor');
		$Supervisor = $reference->getValue();
		$ReturnedSupervisors=array();

		foreach($Supervisor as $key => $value ){
			$ReturnedSupervisors[]=array(
				"key"=>$key,
			    "phone"=>$value["phone"],
			    "busName"=>$value['busName'],
			    "email"=>$value['email'],
			    "name"=>$value['name'],
			);
		}
		return ($ReturnedSupervisors);
	}
	public function update($SupervisorEmailKey,Request $request){
		$this->validate($request,[
            'name'=>'required|string|max:191',
            'busName'=>'required|string|max:191',
            'email'=>'required|string|email|max:191',
            'phone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		$SupervisorEmailKey= str_replace('.', '', $request['email']);
		$reference = $database->getReference('Supervisor/'.$SupervisorEmailKey);
		$SupervisorData=array(
		  	'busName' => $request['busName'],
		  	'email' => $request['email'],
		  	'name' => $request['name'],
		  	'password' => '123456789',
		  	'phone' => $request['phone'],
		);	

		$reference->update($SupervisorData);
		return 8;
	}
	public function delete($SupervisorEmailKey){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		
		$reference = $database->getReference('Supervisor/'.$SupervisorEmailKey);
		$reference->remove();
		return 7;
	}
}
