<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
class FirebaseController extends Controller
{
    public function create(Request $request){
        $this->validate($request,[
            'name'=>'required|string|max:191',
            'busName'=>'required|string|max:191',
            'address'=>'required|string|max:191',
            'email'=>'required|string|email|max:191',
            'phone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();
		$database=$firebase->getDatabase();

	// Generate New Bus Key Like Bus201
	$StudentEmailKey= str_replace('.', '', $request['email']);
	$StudentData=array(
		  	'address' => $request['address'],
		  	'busName' => $request['busName'],
		  	'email' => $request['email'],
		  	'name' => $request['name'],
		  	'password' => '123456789',
		  	'phone' => $request['phone'],
		);	
// $CreateNewStudent= [
//     'Student/'.$StudentEmailKey=> $StudentData
// ];

// $database->getReference() // this is the root reference
//    ->set($CreateNewStudent);

		$newPost= $database
		          ->getReference('Student/'.$StudentEmailKey)
		          ->set($StudentData);
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
		$reference = $database->getReference('Student');
		$Students = $reference->getValue();
		$ReturnedStudents=array();

		foreach($Students as $key => $value ){
			$ReturnedStudents[]=array(
				"key"=>$key,
			    "phone"=>$value["phone"],
				"address"=>$value['address'],
			    "busName"=>$value['busName'],
			    "email"=>$value['email'],
			    "name"=>$value['name'],
			);
		}
		return ($ReturnedStudents);
	}
	public function update($StudentEmailKey,Request $request){
		$this->validate($request,[
            'name'=>'required|string|max:191',
            'busName'=>'required|string|max:191',
            'address'=>'required|string|max:191',
            'email'=>'required|string|email|max:191',
            'phone'=>'max:11|min:11|regex:/(01)[0-9]{9}/',
        ]);
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		// $StudentEmailKey= str_replace('.', '', $request['email']);
		$reference = $database->getReference('Student/'.$StudentEmailKey);
		$StudentData=array(
		  	'address' => $request['address'],
		  	'busName' => $request['busName'],
		  	'email' => $request['email'],
		  	'name' => $request['name'],
		  	'password' => '123456789',
		  	'phone' => $request['phone'],
		);
		$reference->update($StudentData);	
		// $reference->update([
		//           	'address' => $request['address'],
		//           	'busName' => $request['busName'],
		//           	'email' => $request['email'],
		//           	'name' => $request['name'],
		//           	'password' => $request['password'],
		//           	'phone' => $request['phone'],
		//           ]);
		return 8;
	}
	public function delete($StudentEmailKey){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/buswhere-40b83-firebase-adminsdk-qd9wu-fe4db71c61.json');
		$firebase= (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://buswhere-40b83.firebaseio.com')
                        ->create();	
		$database=$firebase->getDatabase();
		$reference = $database->getReference('Student/'.$StudentEmailKey);
		$reference->remove();
	}
}
	