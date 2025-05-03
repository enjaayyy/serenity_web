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

        $questions = $this->database->getReference("administrator/doctors/" . $id . "/activeQuestionnaires");
        $get = $questions->getSnapshot();
        $questiondata = $get->getValue();

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
                'description' => isset($data['descrip']) ? $data['descrip'] : null,
            ];
        }

        $appointmentRef = $this->database->getReference('administrator/doctors/' . $id . '/scheduled_appointments/')->getSnapshot()->getValue();
        $appointmentCount = is_array($appointmentRef) ? count($appointmentRef) : 0;
        $appointmentList = [];
        if($appointmentRef){
            foreach($appointmentRef as $key => $apts){
                $newDate = (new \DateTime($apts['appointmentDate']))->format("F j, Y");
                $appointmentList[] = [
                    'aptTitle' => $apts['appointmentTitle'],
                    'aptSched' => $newDate,
                    'aptName' => $apts['appointmentPatient'],
                ];
            }
        }
        
        return view("administrator.doctorProfile", [
            'details' => $details,
            'patient' => $patient,
            'patientCount' => $patientCount,
            'appointmentList' => $appointmentList,
            'appointmentCount' => $appointmentCount,
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


}
 