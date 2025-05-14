<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;

class AdminController extends Controller
{
    protected $database;
    protected $storage;
    protected $bucket;
    
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

        $requestCount = is_array($data) ? count($data) : 0;
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
        return view('administrator.adminReqeusts', [
            'details' => $details,
            'requestCount' => $requestCount,
        ]);    
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
        
        $credentials = [];

        foreach($data['credentials'] as $url){
            $fileName = basename(explode('?', $url)[0]);
            $credentials[] = [
                'url' => $url,
                'filename' => $fileName,
            ];
        }
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
                'credentials' => $credentials,
                'issued' => $data['licenseIssued'],
                'expire' => $data['licenseExpired'],
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
        $doctorCount = is_array($data) ? count($data) : 0;

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
         return view('administrator.doctors', [
            'details' => $details,
            'doctorCount' => $doctorCount, 
        ]);
        }
        else {
            return redirect()->route('login');
        }
    }

    public function viewdoctor($id){
        $view = $this->database->getReference("administrator/doctors/" . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $patients = $this->database->getReference('administrator/doctors/' . $id . "/mypatients" . "/");
        $patientSnap = $patients->getSnapshot();
        $patientData = $patientSnap->getValue();

        $patient = [];
        $patientCount = is_array($patientData) ? count($patientData) : 0;

        if($patientData){
            foreach($patientData as $id => $patientindex){
                $userID = $patientindex['patientID'];

                $userRef = $this->database->getReference('administrator/users/' . $userID);
                $userSnapshot = $userRef->getSnapshot();
                $userData = $userSnapshot->getValue();

                if($userData){
                    $patient [] = [
                    'id' => $id,
                    'userID' => $userID,
                    'name' => $userData['full_name'],
                    'img' => isset($userData['profile_image']) ? $userData['profile_image'] : null,
                    'conditions' => $userData['conditions'],
                    ];
                }
            }
        }

        $credentials = [];

        foreach($data['credentials'] as $url){
            $fileName = basename(explode('?', $url)[0]);
            $credentials[] = [
                'url' => $url,
                'filename' => $fileName,
            ];
        }

        $doctorController = new DoctorController($this->database, $this->storage);
        $details = $doctorController->getDoctorData($id);

        $getChanges = $this->database->getReference('administrator/changes/' . $id)->getSnapshot()->getValue();

        if($getChanges){
            $changes = [
                'address' => $getChanges['address'],
                'age' => $getChanges['age'],
                'descrip' => $getChanges['descrip'],
                'expire' => $getChanges['expire'],
                'gender' => $getChanges['gender'],
                'issued' => $getChanges['issued'],
                'license' => $getChanges['license'],
                'name' => $getChanges['name'],
                'profession' => $getChanges['profession'],
                'years' => $getChanges['years'],
            ];
        }

        return view("administrator.doctorProfile", [
            'details' => $details,
            'patient' => $patient,
            'patientCount' => $patientCount,
            'changes' => $changes ?? null,
        ]);

    }

    public function deactivate($id){
            $getDoctor = $this->database->getReference('administrator/doctors/' . $id)->getSnapshot()->getValue();
            if($getDoctor){
                $this->database->getReference('administrator/archives/' . $id)->update($getDoctor);
                $this->database->getReference('administrator/doctors/' . $id)->remove();

                return redirect()->route('doctors');
            }
            else{
                $getPatient = $this->database->getReference('administrator/users/' . $id)->getSnapshot()->getValue();
                if($getPatient){
                    $this->database->getReference('administrator/archives/' . $id)->update($getPatient);
                    $this->database->getReference('administrator/users/' . $id)->remove();

                    return redirect()->route('patients');
                }
            }
    }

    public function viewArchive(){
        if(Session::get('user') == 'admin'){
        $view = $this->database->getReference('administrator/archives/');
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $archiveCount = is_array($data) ? count($data) : 0;

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
        return view("administrator.arhive", [
            'details' => $details,
            'archiveCount' => $archiveCount,    
        ]);
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
                $this->database->getReference('administrator/archives/' . $id)->remove();
            }
            else if($archiveRef['account-type'] === 'user'){
                $this->database->getReference('administrator/users/' . $id)->update($archiveRef);
                $this->database->getReference('administrator/archives/' . $id)->remove();
            }
        }
        return redirect()->route('adminDashboard');
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

            $videoTags = $request->input('tags', []);

            $videoData = [
                'videoUrl' => $vidlink,
                'title' => $request->title,
                'details' => $request->details,
                'tags' => $videoTags,
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
            $reportsRef = $this->database->getReference('administrator/reports/')->getSnapshot()->getValue();
            $requestsRef = $this->database->getReference('administrator/doctorRequests/')->getSnapshot()->getValue();
            $archiveRef = $this->database->getReference('administrator/archives/')->getSnapshot()->getValue();

            $patientCount = is_array($patientRef) ?  count($patientRef) : 0;
            $doctorCount = is_array($doctorRef) ? count($doctorRef) : 0;
            $reportsCount =  is_array($reportsRef) ? count($reportsRef) : 0;
            $requestsCount = is_array($requestsRef) ? count($requestsRef) : 0;
            $archiveCount = is_array($archiveRef) ? count($archiveRef) : 0;
            $videos = [];

            if($data){
                foreach($data as $id => $vids){
                    $videos[] = [
                        'id' => $id,
                        'title' => $vids['title'] ?? 'No title',
                        'details' => $vids['details']?? 'No Description',
                        'video' => $vids['videoUrl']?? null,
                        'tags' => $vids['tags'] ?? null,
                    ];
                }
            }
            return view('administrator.adminHome', [
                'videos' => $videos,
                'doctorCount' => $doctorCount,
                'patientCount' => $patientCount,
                'reportsCount'=> $reportsCount,
                'requestsCount' => $requestsCount,
                'archiveCount' => $archiveCount,
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

            $patientCount = is_array($data) ? count($data) : 0;

            if($data){
                foreach($data as $id => $user){
                    $details[] = [
                        'id' => $id,
                        'name' => $user['full_name'],
                        'email' => $user['email'],
                        'conditions' => $user['conditions'],
                        'number' => $user['phone_number'],
                    ];
                }
            }
            return view('administrator.adminPatients',  [
                'details' =>  $details,
                'patientCount' => $patientCount,
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function viewReports(){
        if(Session::get('user') == 'admin'){
            $getReports = $this->database->getReference('administrator/reports')->getSnapshot()->getValue();
            
            $reportCount = is_array($getReports) ? count($getReports) : 0;

            $reports = [];
            if($getReports){
                foreach($getReports as $refID => $details){
                    $reportedID = $details['reportedId'];
                    $reporterID = $details['reporterId'];

                    $reporterName;
                    $reportedName;
                    
                    $findDoctor = $this->database->getReference('administrator/doctors/' . $reporterID)->getSnapshot()->getValue();

                    if($findDoctor){
                        $findReportedPatient = $this->database->getReference('administrator/users/' . $reportedID)->getSnapshot()->getValue();
                        $reporterName = $findDoctor['name'];
                        $reportedName = $findReportedPatient['full_name'];
                    }else{
                        $findPatient = $this->database->getReference('administrator/users/' . $reporterID)->getSnapshot()->getValue();
                        $findReportedDoctor = $this->database->getReference('administrator/doctors/' . $reportedID)->getSnapshot()->getValue();
                        $reporterName = $findPatient['full_name'];
                        $reportedName = $findReportedDoctor['name'];   
                    }


                    $formattedTime = date("F j, Y g:i A", strtotime($details['timestamp']));
                    $reports[] = [
                        'reporter' => $reporterName,
                        'reported' => $reportedName,
                        'details' => $details['reportDetails'],
                        'timestamp' => $formattedTime,
                    ];
                }
            }

            return view('administrator.reportList', [
                'reports' => $reports,
                'reportcount' => $reportCount,
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function profileChanges($id, Request $request){
        if(Session::get('user') == 'admin'){
            $action = $request->input('action');

            if($action === 'accept'){
                $newData = [
                    'name' => $request->input('change-name'),
                    'profession' => $request->input('change-profession'),
                    'age' => $request->input('change-age'),
                    'years' => $request->input('change-years'),
                    'gender' => $request->input('change-gender'),
                    'address' => $request->input('change-address'),
                    'license' => $request->input('change-license'),
                    'issued' => $request->input('change-issued'),
                    'expire' => $request->input('change-expire'),
                    'descrip' => $request->input('change-descrip'),
                ];

                $this->database->getReference('administrator/doctors/' . $id)->update($newData);
                $this->database->getReference('administrator/changes/' . $id)->remove();
                return redirect()->route('doctors');
            }
            else if($action === 'decline'){
                $this->database->getReference('administrator/changes/' . $id)->remove();
                return redirect()->route('doctors');
            }
        }
        else{
            return redirect()->route('login');
        }
    }

}
 