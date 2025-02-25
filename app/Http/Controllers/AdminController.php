<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;

class AdminController extends Controller
{
    public function __construct(Database $database, Storage $storage)
    {
        $this->database = $database;
        $this->storage = $storage;
        $this->bucket = $this->storage->getBucket();
    }

    public function viewRequests()
    {
        if(Session::get('user') == 'admin'){
        $view = $this->database->getReference('administrator/doctorRequests/');
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $details = [];

        if ($data) {
            foreach ($data as $id => $doctor) {
                $details[] = [
                    'id' => $id,
                    'name' => $doctor['doctorFullname'],
                    'email' => $doctor['doctorEmail'],
                    'profession' => $doctor['profession'],
                    'specialization' => $doctor['specialization'],
                ];

          
            }
        }
        return view('administrator.adminReqeusts', ['details' => $details]);    
        }
        else {
            return redirect()->route('login');
        }
       
    }

    public function viewRequestDetails($id){
        if(Session::get('user') == 'admin'){
        $view = $this->database->getReference('administrator/doctorRequests/' . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        if($data){
            $details = [
                'id' => $id,
                'name' => $data['doctorFullname'],
                'age' => $data['age'],
                'email' => $data['doctorEmail'],
                'gender' =>$data['gender'],
                'license' =>$data['medicalLicencse'],
                'profession' =>$data['profession'],
                'specialization' => $data['specialization'],
                'address' => $data['workAddress'],
                'years' => $data['yearsOfService'],
                'credentials' => $data['credentials'],
            ];
            return view('administrator.adminRequestDetails', ['details' => $details]);
        }
    }else{
        return redirect()->route('login');
        }
    }

    public function viewDocList(){

        if(Session::get('user') == 'admin'){
        $view = $this->database->getReference('administrator/doctors/');
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $details = []; 

        if($data){
            foreach($data as $id => $doctor) {
                $details[] = [
                    'id' => $id,
                    'docname' => $doctor['name'],
                    'docemail' => $doctor['email'],
                    'docprofession' => $doctor['profession'],
                    'docspecialization' => $doctor['specialization'],
                ];
            }
           
        }
         return view('administrator.doctors', ['details' => $details]);
        }
        else {
            return redirect()->route('login');
        }
    }

    public function viewdoctor($id){
        $view = $this->database->getReference("administrator/doctors/" . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $questions = $this->database->getReference("administrator/doctors/" . $id . "/activeQuestionnaires");
        $get = $questions->getSnapshot();
        $questiondata = $get->getValue();

        $patients = $this->database->getReference('administrator/doctors/' . $id . "/mypatients" . "/");
        $patientSnap = $patients->getSnapshot();
        $patientData = $patientSnap->getValue();

        $patient = [];

        if($patientData){
            foreach($patientData as $id => $patientindex){
                $userID = $patientindex['userID'];

                $userRef = $this->database->getReference('administrator/users/' . $userID);
                $userSnapshot = $userRef->getSnapshot();
                $userData = $userSnapshot->getValue();

                if($userData){
                    $patient [] = [
                    'id' => $id,
                    'userID' => $userID,
                    'name' => $userData['full_name'],
                ];
                }
            }
        }

        if($data) {
            $details = [
                'id' => $id,
                'name' => $data['name'],
                'age' => $data['age'],
                'email' => $data['email'],
                'gender' =>$data['gender'],
                'license' =>$data['license'],
                'profession' =>$data['profession'],
                'specialization' => $data['specialization'],
                'address' => $data['address'],
                'years' => $data['years'],
                'credentials' => $data['credentials'],
                'questionnaires' => $questiondata ? $questiondata : [],
                'profile' => isset($data['profilePic']) ? $data['profilePic'] : null,
                'description' => isset($data['description']) ? $data['description'] : "No Data",
            ];
        }
        return view("administrator.doctorProfile", [
            'details' => $details,
            'patient' => $patient,
        ]);

    }

    public function deactivate($id){
        $getDoctor = $this->database->getReference('administrator/doctors/' . $id)->getSnapshot()->getValue();
            $this->database->getReference('administrator/archives/' . $id)->set($getDoctor);
            $this->database->getReference('administrator/doctors/' . $id)->remove();
            return redirect()->route('doctors');
    }

    public function viewArchive(){
        if(Session::get('user') == 'admin'){
        $view = $this->database->getReference('administrator/archives/');
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $details = [];
        
            if($data){
            foreach($data as $id => $doctor){
                $details[] = [
                    'id' => $id,
                    'name' => isset($doctor['name']) ? $doctor['name'] : $doctor['full_name'],
                    'email' => $doctor['email'],
                    'specialization' => isset($doctor['specialization']) ? $doctor['specialization'] : $doctor['conditions'],
                    'profession' => isset($doctor['profession']) ? $doctor['profession'] : 'Patient',
                ];
            }
        
        }
        return view("administrator.arhive", ['details' => $details]);
        }
        else{
            return redirect()->route('login');
        }
        
    }

    public function activate($id){
        $archiveRef = $this->database->getReference('administrator/archives/' . $id)->getSnapshot()->getValue();

        if($archiveRef) {
            if($archiveRef['account-type'] === 'doctor'){
                $this->database->getReference('administrator/doctors/' . $id)->update($archiveRef);
            }
            else if($archiveRef['account-type'] === 'patient'){
                $this->database->getReference('administrator/users/' . $id)->update($archiveRef);
            }
        }
        return redirect()->route('doctors');
    }

    public function uploadvid(Request $request){

        if($request->hasFile('video')){
            $video = $request->file('video');

            $vidName = $video->getClientOriginalName();
            $vidpath = $video->getPathname();
            $storagePath = 'videos/' . $vidName;

            $uploadedvid = $this->bucket->upload(
                fopen($vidpath, 'r'), [
                    'name' => $storagePath
                ]
            );

            $expiresAt = new \DateTime('+1 year');
            $vidlink = $uploadedvid->signedUrl($expiresAt);

            $videoData = [
                'videoUrl' => $vidlink,
                'title' => $request->title,
                'details' => $request->details,
            ];

            $success = $this->database->getReference('administrator/videos/')->push($videoData);
            if($success){
                return redirect()->route('adminDashboard');
            }
        }
        else{
            return redirect()->route('adminDashboard')->with('UploadFailed!');
        }
    }

    public function viewDash(){
        $user = Session::get('user');
        if($user === 'admin'){
            $data = $this->database->getReference('administrator/videos/')->getSnapshot()->getValue();
            $doctorRef = $this->database->getReference('administrator/doctors/')->getSnapshot()->getValue();
            $patientRef = $this->database->getReference('administrator/users/')->getSnapshot()->getValue();

            $patientCount = count($patientRef);
            $doctorCount = count($doctorRef);
            $videos = [];

            if($data){
                foreach($data as $id => $vids){
                    $videos[] = [
                        'id' => $id,
                        'title' => $vids['title'] ?? 'No title',
                        'details' => $vids['details']?? 'No Description',
                        'video' => $vids['videoUrl']?? null,
                    ];
                }
            }
            return view('administrator.adminHome', [
                'videos' => $videos,
                'doctorCount' => $doctorCount,
                'patientCount' => $patientCount,
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function viewPatients(){
        if(Session::get('user') == 'admin'){
            $view  = $this->database->getReference('administrator/users');
            $snapshot = $view->getSnapshot();
            $data = $snapshot->getValue();
            
            $details = [];

            if($data){
                foreach($data as $id => $doctor){
                    $details[] = [
                        'id' => $id,
                        'name' => $doctor['full_name'],
                        'email' => $doctor['email'],
                        'conditions' => $doctor['conditions'],
                        'number' => $doctor['phone_number'],
                    ];
                }
            }
            return view('administrator.adminPatients',  ['details' =>  $details]);
        }
        else{
            return redirect()->route('login');
        }
    }



}
 