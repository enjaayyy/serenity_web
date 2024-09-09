<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;

class DoctorController extends Controller
{
    public function __construct(Database $database, Storage $storage){

        $this->database = $database;
        $this->storage = $storage;
        $this->bucket = $this->storage->getBucket();
        
    }

    public function docDashboard(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');
            $view = $this->database->getReference('administrator/doctors/' . $id);
            $snapshot = $view->getSnapshot();
            $data = $snapshot->getValue();
 
            if($data){
                $doctorData = [
                    'id' => $id,
                    'name' => $data['name'],
                    'prof' => $data['profession'],
                    'pic' => isset($data['profilePic']) ? $data['profilePic'] : null,
                ];
                return view('doctor.dashboard', ['doctorData' =>  $doctorData]);  
            }
          
        }
        else{
            return redirect()->route('login');
        }
    }

    public function doctorProfile(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');
            $view = $this->database->getReference('administrator/doctors/' . $id);
            $snapshot = $view->getSnapshot();
            $data = $snapshot->getValue();

            if($data){
                $doctorData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'prof' => $data['profession'],
                    'spec' => $data['specialization'],
                    'age' => $data['age'],
                    'yrs' => $data['years'],
                    'license' => $data['license'],
                    'gender' => $data['gender'],
                    'address' => $data['address'],
                    'pic' => isset($data['profilePic']) ? $data['profilePic'] : null,
                    'descrip' => isset($data['description']) ? $data['description'] : null,
                    'graduated' => isset($data['graduated']) ? $data['graduated'] : null,
                    'questions' => $data['questionnaires'],
                    'creds' => $data['credentials'],
                ];
                return view('doctor/profile', ['doctorData' =>  $doctorData]);  
            }
        }
        else{
            return redirect()->route('login');
        }   
    }

    public function uploadpp(Request $request){
        if($request->hasFile('pp')){
            $id = Session::get('id');

            $files = $request->file('pp');
            $filename = $files->getClientOriginalName();
            $filepath = $files->getPathname();
            $firebasepath = 'profilePic/' . $filename;

            $uploadFile  = $this->bucket->upload(
                fopen($filepath, 'r'), [
                    'name' => $firebasepath
                ]
                );

                $expiresAt = new \DateTime('+1 year');
                $url = $uploadFile->signedUrl($expiresAt);

                $newData = [
                    'profilePic' => $url,
                ];

                $query = $this->database->getReference('administrator/doctors/' . $id)->update($newData);

                if($query){
                    return redirect()->route('docProfile');
                }
        }
    }
    public function getDetails(Request $request){
        $id = Session::get('id');
        $view = $this->database->getReference('administrator/doctors/' . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        if($data){
            $newData = [
                'description' => $request->textarea,
            ];
            $this->database->getReference('administrator/doctors/' . $id)->update($newData);
        }
        
        Session::forget('editMode');
        return redirect()->route('docProfile');
    }

    public function editDetails(){

        Session::put('editMode', true);
        return redirect()->route('docProfile');
    }

    public function updateQuestions(Request $request){
        $id = Session::get('id');
        $view = $this->database->getReference('administrator/doctors/' . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        if($data){
            $newData = [
                'questionnaires' => $request->questions,
            ];

            $this->database->getReference('administrator/doctors/' . $id)->update($newData);
        }

        Session::forget('editqst');
        return redirect()->route('docProfile');
    }

    public function editQuestions(){

        Session::put('editqst', true);
        return redirect()->route('docProfile');
    }

    public function addGraduate(Request $request){
        $id = Session::get('id');
        $view = $this->database->getReference('administrator/doctors/' . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        if($data){
            $newData = [
                'graduated' => $request->textarea,
            ];

            $this->database->getReference('administrator/doctors/' . $id)->update($newData);
        }
        return redirect()->route('docProfile');
    }

    public function showRequests(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');
            $requestRef = $this->database->getReference('administrator/doctors/' . $id . '/appointments/');
            $requestSnapshot = $requestRef->getSnapshot();
            $requestData = $requestSnapshot->getValue();

            $docRef = $this->database->getReference('administrator/doctors/'. $id);
            $docSnap = $docRef->getSnapshot();
            $docData = $docSnap->getValue();

            $doctorData = [];
            
            if($docData){
                $doctorData = [
                    'id' => $id,
                    'name' => $docData['name'],
                    'prof' => $docData['profession'],
                    'pic' => isset($docData['profilePic']) ? $docData['profilePic'] : null,
                ];
            }

            $patientData = [];

            if($requestData){
                foreach($requestData as $reqID => $request){
                    $userID = $request['userUID'];
                    $userRef = $this->database->getReference('administrator/users/'. $userID);
                    $userSnapshot = $userRef->getSnapshot();
                    $userData = $userSnapshot->getValue();

                    if($userData){
                        $patientData[] = [
                            'id' => $reqID,
                            'status' => $request['status'],
                            'timestamp' => $request['timestamp'],
                            'userID' => $userID,
                            'condition' => $userData['condition'],
                            'email' => $userData['email'],
                            'name' => $userData['full_name'],
                            'phonenum' => $userData['phone_number'],
                            'username' => $userData['username'],
                        ];
                    }
                }
            }
           return view('doctor/requests', [
            'patientData' => $patientData,
            'doctorData' => $doctorData,
        ]);

        }
        else{
            return redirect()->route('login');
        }
    }

    public function acceptPatient(Request $request, $id){
        if(Session::get('user') == 'doctor'){
            $docID = Session::get('id');
            $requestRef = $this->database->getReference('administrator/doctors/'. $docID . '/' . 'appointments/' . $id);
            $refSnapshot = $requestRef->getSnapshot();
            $refData = $refSnapshot->getValue();

            if($refData){
                if($request->input('action') == 'accept'){
                    $newData = [
                    'status' => 'approved',
                    'timestamp' => $refData['timestamp'],
                    'userID' =>  $refData['userUID'],
                    ];
                    $newStatus = [
                        'status' => 'approved',
                        'docID' => $docID,
                        'timestamp' => $refData['timestamp'],
                    ];

                $this->database->getReference('administrator/doctors/' . $docID . '/' . 'mypatients/' . $id)->set($newData);
                $this->database->getReference('administrator/users/'. $refData['userUID'] . '/' . 'mydoctor/' . $id)->update($newStatus);
                $this->database->getReference('administrator/doctors/' . $docID . '/' . 'appointments/' . $id)->remove();    
                }
                elseif($request->input('action') == 'delete'){
                    $this->database->getReference('administrator/doctors/' . $docID . '/' . 'appointments/' . $id)->remove(); 
                }
                
        }
        return redirect()->route('showRequests');
    }
    else{
        return redirect()->route('login');
    }
}

    public function viewPatients(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');
            $requestRef = $this->database->getReference('administrator/doctors/' . $id . '/mypatients/');
            $requestSnapshot = $requestRef->getSnapshot();
            $requestData = $requestSnapshot->getValue();

            $docRef = $this->database->getReference('administrator/doctors/'. $id);
            $docSnap = $docRef->getSnapshot();
            $docData = $docSnap->getValue();

            if($docData){
                $doctorData = [
                    'id' => $id,
                    'name' => $docData['name'],
                    'prof' => $docData['profession'],
                    'pic' => isset($docData['profilePic']) ? $docData['profilePic'] : null,
                ];
            }

            $patientData = [];

            if($requestData){
                foreach($requestData as $reqID => $request){
                    $userID = $request['userID'];
                    $userRef = $this->database->getReference('administrator/users/'. $userID);
                    $userSnapshot = $userRef->getSnapshot();
                    $userData = $userSnapshot->getValue();

                    if($userData){
                        $patientData[] = [
                            'id' => $reqID,
                            'status' => $request['status'],
                            'timestamp' => $request['timestamp'],
                            'userID' => $userID,
                            'condition' => $userData['condition'],
                            'email' => $userData['email'],
                            'name' => $userData['full_name'],
                            'phonenum' => $userData['phone_number'],
                            'username' => $userData['username'],
                        ];
                    }
                }
            }
           return view('doctor/patientlist', [
            'patientData' => $patientData,
            'doctorData' => $doctorData,
        ]);
        }
        else{
            return redirect()->route('login');
        }
    }
}

