<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;
use App\Http\Controllers\DateTime;

class DoctorController extends Controller
{
    protected $database;
    protected $storage;
    protected $bucket;

    public function __construct(Database $database, Storage $storage){

        $this->database = $database;
        $this->storage = $storage;
        $this->bucket = $this->storage->getBucket();
        
    }

    private function getRequest($docID){
        $requestRef = $this->database->getReference('administrator/doctors/' . $docID . '/Appointments')->getSnapshot()->getValue();
        $requestCount = is_array($requestRef) ? count($requestRef) : 0;
        if($requestRef){
            foreach($requestRef as $key => $reqs){
                $patientID = $reqs['userId'];
                $reqeustDate = (new \DateTime($reqs['timestamp']))->format("F j, Y");
                $patientRef = $this->database->getReference('administrator/users/' . $patientID)->getSnapshot()->getValue();
                    if($patientRef){
                            $patientData[] = [
                                'refId' => $key,
                                'patientId' => $patientID,
                                'name' => $patientRef['full_name'],
                                'email' => $patientRef['email'],
                                'conditions' => $patientRef['conditions'],
                                'img' => isset($patientRef['profile_image']) ? $patientRef['profile_image'] : null,
                                'timestamp' =>  $reqeustDate,
                            ];
                    }
            }
        }
        else{
            $patientData = null;
        }
        return [$patientData, $requestCount];
    }

    private function getUpcommingAppointments($docID){
        $AppointmentsRef = $this->database->getReference('administrator/doctors/' . $docID . '/scheduled_appointments/')->getSnapshot()->getValue();

        $currentMonth = date('m');
        $currentYear = date('Y');
        $appointmentCount = is_array($AppointmentsRef) ? count($AppointmentsRef) : 0;
        $appointmentData = [];
            if($AppointmentsRef){
                foreach($AppointmentsRef as $key => $apts){
                $appointDate = new \DateTime($apts['appointmentDate']);
                $aptMonth = $appointDate->format('m');
                $aptYear = $appointDate->format('Y');

                if($aptMonth === $currentMonth && $aptYear === $currentYear) {
                    $newDate = (new \DateTime($apts['appointmentDate']))->format("F j, Y");
                    $appointmentData[] = [
                        'appointmentTitle' => $apts['appointmentTitle'],
                        'appointmentPatient' => $apts['appointmentPatient'],
                        'appointmentColor' => $apts['color'],
                        'appointmentDate' => $newDate,
                    ];
                }
            }
        }
        else {
            $appointmentData = null;
        }
        
        return [$appointmentData,  $appointmentCount];
    }

    private function getConditionCount($docID){
        $doctorRef = $this->database->getReference('administrator/doctors/' . $docID . '/mypatients/')->getSnapshot()->getValue();
        $anxiety = 0;
        $insomnia = 0;
        $pts = 0;
        if($doctorRef){
            foreach($doctorRef as $key => $docData){
                $patientID = $docData['patientID'];

                $patientRef = $this->database->getReference('administrator/users/' . $patientID . '/conditions/')->getSnapshot()->getValue();

                if($patientRef){
                    foreach($patientRef as $conditionCount){
                        if($conditionCount === "Anxiety"){
                            $anxiety++;
                        }
                        else if($conditionCount === "Insomnia"){
                            $insomnia++;
                        }
                        else if($conditionCount === "Post Traumatic Stress"){
                            $pts++;
                        }
                    }
                }
            }
        }

        return [$anxiety, 
                $insomnia, 
                $pts];
       
    }


    public function getDoctorData($id){
        $getDoc = $this->database->getReference('administrator/doctors/' . $id)->getSnapshot()->getValue();

        $credentials = [];

        foreach($getDoc['credentials'] as $url){
            $fileName = basename(explode('?', $url)[0]);
            $credentials[] = [
                'url' => $url,
                'filename' => $fileName,
            ];
        }

        if($getDoc){
            $doctorData = [
                    'docID' => $id,
                    'name' => $getDoc['name'],
                    'email' => $getDoc['email'],
                    'prof' => $getDoc['profession'],
                    'spec' => $getDoc['specialization'],
                    'age' => $getDoc['age'],
                    'yrs' => $getDoc['years'],
                    'license' => $getDoc['license'],
                    'issued' => $getDoc['issued'],
                    'expired' => $getDoc['expire'],
                    'gender' => $getDoc['gender'],
                    'address' => $getDoc['address'],
                    'pic' => isset($getDoc['profilePic']) ? $getDoc['profilePic'] : null,
                    'descrip' => isset($getDoc['descrip']) ? $getDoc['descrip'] : null,
                    'graduated' => isset($getDoc['graduated']) ? $getDoc['graduated'] : null,
                    'questions' => isset($getDoc['activeQuestionnaires']) ? $getDoc['activeQuestionnaires'] : null,
                    'creds' => $credentials,
                    'appointments' => isset($getDoc['scheduled_appointments']) ? $getDoc['scheduled_appointments'] : null,
                    'templates' => isset($getDoc['savedQuestionnaires']) ? $getDoc['savedQuestionnaires'] : null,
            ];
        }
        return $doctorData;
    }


    public function docDashboard(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');
            $data = $this->database->getReference('administrator/doctors/' . $id)->getSnapshot()->getValue();
           
            if($data){
                $patientRef = $this->database->getReference('administrator/doctors/' . $id . '/mypatients/')->getSnapshot()->getValue();
                $patientCount = is_array($patientRef) ? count($patientRef) : 0;

                    $doctorData = $this->getDoctorData($id);
                    list($requestList,  $requestCount) = $this->getRequest($id);
                    list($appointmentData, $appointmentCount) = $this->getUpcommingAppointments($id);
                    list($anxietyCount, $insomniaCount, $ptsCount) = $this->getConditionCount($id);

                    return view('doctor.dashboard', [
                        'doctorData' =>  $doctorData,
                        'patientCount' => $patientCount,
                        'requestCount' => $requestCount,
                        'appointmentCount' => $appointmentCount,
                        'appointmentList'=> $appointmentData,
                        'requestList' => $requestList,
                        'anxietycount' => $anxietyCount,
                        'insomniacount' => $insomniaCount,
                        'ptscount' =>  $ptsCount,
                    ]);  
            }
          
        }
        else{
            return redirect()->route('login');
        }
    }

    public function doctorProfile(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');
            $data = $this->database->getReference('administrator/doctors/' . $id)->getSnapshot()->getValue();

            if($data){

                $doctorData = $this->getDoctorData($id);

                list($appointmentData, $appointmentCount) = $this->getUpcommingAppointments($id);

                return view('doctor/profile', [
                    'doctorData' =>  $doctorData,
                    'appointmentCount' => $appointmentCount,
                    'appointmentList'=> $appointmentData,
                ]);  
            }
        }
        else{
            return redirect()->route('login');
        }   
    }

    public function getQuestionnaires(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');
            $data = $this->database->getReference('administrator/doctors/' . $id)->getSnapshot()->getValue();

            if($data){
                $QuestionnaireData = [
                    'questions' => isset($data['activeQuestionnaires']) ? $data['activeQuestionnaires'] : null,
                    'templates' => isset($data['savedQuestionnaires']) ? $data['savedQuestionnaires'] : null,
                    'activeScore' => isset($data['activeScoring']) ? $data['activeScoring'] : null,
                ];
            }

            return view('doctor/questionnaires', [
                'doctorData' => $QuestionnaireData,
            ]);
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

    public function addcredentials(Request $request){
        if($request->hasFile('imagefile')){
            $docID = Session::get('id');

            $files = $request->file('imagefile');
            $filename = $files->getClientOriginalName();
            $filepath = $files->getPathname();
            $firebasepath = 'credentials/' . $filename;

            $uploadFile  = $this->bucket->upload(
                fopen($filepath, 'r'), [
                    'name' => $firebasepath
                ]
            );

            $expiresAt = new \DateTime('+1 year');
            $url = $uploadFile->signedUrl($expiresAt);

            $credentialsRef = $this->database->getReference('administrator/doctors/' . $docID . '/credentials/')->getSnapshot()->getValue();
            $credentialsArray = $credentialsRef;
            $credentialsArray[] = $url;

            $this->database->getReference('administrator/doctors/' . $docID . '/credentials/')->set($credentialsArray);

            return redirect()->route('docProfile');
        }
    }


    public function editDetails(Request $request){
        if(Session::get('user') == 'doctor'){
            $docID = Session::get('id');

                $newData = [
                    'name' => $request->input('name-input'),
                    'profession' => $request->input('spec-input'),
                    'age' => $request->input('age-input'),
                    'gender' => $request->input('gender-input'),
                    'years' => $request->input('years-input'),
                    'license' => $request->input('license-input'),
                    'issued' => $request->input('issued-input'),
                    'expire' => $request->input('expiry-input'),
                    'address' => $request->input('address-input'),
                    'descrip' => $request->input('detail-textarea'),
                ];

            $this->database->getReference('administrator/changes/' . $docID)->update($newData);
            return redirect()->route('docProfile');
        }
        
    }

    public function updateQuestions(Request $request){
        $id = Session::get('id');
        $questions = $request->input('question');
        $legends = $request->input('legend');
        $values = $request->input('value');
        $title = $request->input('title');

        $questionData = [];

        foreach($questions as $index => $question){
            $questionData['Q' . ($index + 1)] = [
                'question' => $question,
                'legend' => array_combine(range(0, count($legends[$index]) - 1), $legends[$index]),
                'value' => array_combine(range(0, count($values[$index]) - 1), $values[$index]),
            ];
        }
        
        $questionData['title'] = $title;

        $this->database->getReference('administrator/doctors/' . $id . '/SavedQuestionnaires/' . $title)->set($questionData);

        $view = $this->database->getReference('administrator/doctors/' . $id . '/activeQuestionnaires');
        $questSnap = $view->getSnapshot();
        $questData = $questSnap->getValue();
        
        $this->database->getReference('administrator/doctors/' . $id . '/activeQuestionnaires')->set($questionData);

        Session::put('activeTemplate', true);
        return redirect()->route('docProfile');
    }

   
    public function editQuestions(Request $request){
        $id = Session::get('id');

        $questions = $request->input('questions');
        $title = $request->input('title');
        
        $questionData = [];

        foreach($questions as $index => $question){
            $legends = isset($question['legend']) ? $question['legend'] : [];
            $values = isset($question['value']) ? $question['value'] : [];

            $questionData['Q' . ((int) $index + 1)] = [
                'question' => $question['question'],
                'legend' => $legends,
                'value' => $values,
            ];
        }

        $questionData['title'] = $title;

        $this->database->getReference('administrator/doctors/' . $id . '/activeQuestionnaires')->update($questionData);

        return redirect()->route('docProfile');
    }

    public function newTemplate(Request $request){
        $id = Session::get('id');
        $newQuest = $request->input('template');
        $questRef = $this->database->getReference('administrator/doctors/' . $id . '/SavedQuestionnaires/' . $newQuest);
        $questSnap = $questRef->getSnapshot();
        $questData = $questSnap->getValue();

        $oldQuestRef = $this->database->getReference('administrator/doctors/' . $id . '/activeQuestionnaires');
        $oldQuestSnap = $oldQuestRef->getSnapshot();
        $oldQuestData = $oldQuestSnap->getValue();

        $title = isset($oldQuestData['title']) ? $oldQuestData['title'] : null;

        if($oldQuestData){
            $newSaved = $oldQuestData;
            $this->database->getReference('administrator/doctors/' . $id . '/SavedQuestionnaires/' . $title)->set($newSaved);

        }

        if($questData){
            $newActive = $questData;

            $this->database->getReference('administrator/doctors/' . $id . '/activeQuestionnaires')->set($newActive);
        }
        
        Session::put('activeTemplate', true);
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

    public function showAppointments(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');
            $docData = $this->database->getReference('administrator/doctors/'. $id)->getSnapshot()->getValue();
            
            if($docData){
                $doctorData = $this->getDoctorData($id);
            }

            $appointmentData = $this->database->getReference('administrator/doctors/'. $id . '/Appointments/')->getSnapshot()->getValue();
            $appointmentCount = is_array($appointmentData) ? count($appointmentData) : 0;
            
            $patientData = [];
            if($appointmentData){
                foreach($appointmentData as $key => $appoint){
                    $patientID = $appoint['userId'];
                    $patientRef = $this->database->getReference('administrator/users/' . $patientID)->getSnapshot()->getValue();
                        if($patientRef){
                                $patientData[] = [
                                    'refId' => $key,
                                    'patientId' => $patientID,
                                    'name' => $patientRef['full_name'],
                                    'email' => $patientRef['email'],
                                    'conditions' => $patientRef['conditions'],
                                ];
                        }
                }
            }
        
            return view('doctor.requests',[
                'doctorData' => $doctorData,
                'patientData' => $patientData,
                'appointmentCount' => $appointmentCount,
            ]);
        }
        else{
            return redirect()->route('login');
        }
        
    }

    public function acceptPatient(Request $request, $refID){
        if(Session::get('user') == 'doctor'){
            $docID = Session::get('id');
            $refKey = $this->database->getReference('administrator/doctors/' . $docID . '/Appointments/' . $refID)->getSnapshot()->getValue();
            $doctorRef = $this->database->getReference('administrator/doctors/' . $docID)->getSnapshot()->getValue();

            if($refKey){
                if($request->input('action') == 'accept'){
                    $newPatient = [
                        'patientID' => $refKey['userId'],
                        'timestamp' => $refKey['timestamp'],
                        'status' => 'approved',
                    ];
                    $newStatus = [
                        'status' => 'approved',
                        'doctorId' => $docID,
                        'doctorName' => $doctorRef['name'],
                    ];

                    $this->database->getReference('administrator/doctors/' . $docID . '/mypatients/' . $refID)->update($newPatient);
                    $this->database->getReference('administrator/users/'. $refKey['userId'] . '/mydoctors/' . $docID )->update($newStatus);
                    $this->database->getReference('administrator/doctors/' . $docID . '/Appointments/' . $refID)->remove();
                }
                else if($request->input('action') == 'delete'){
                    $this->database->getReference('administrator/doctors/' . $docID . '/Appointments/' . $refID)->remove();
                    $this->database->getReference('administrator/users/'. $refKey['userId'] . '/mydoctors/' . $docID)->remove();
                }
            }
            return redirect()->route('showAppointments');
        }
        else{
            return redirect()->route('login');
        }
   
}

    public function viewPatients(){
        if(Session::get('user') == 'doctor'){
            $id = Session::get('id');

            $docData = $this->database->getReference('administrator/doctors/'. $id)->getSnapshot()->getValue();

            if($docData){
                $doctorData = $this->getDoctorData($id);
            }
            $patientRef = $this->database->getReference('administrator/doctors/' . $id . '/mypatients/')->getSnapshot()->getValue();

            $patientData = [];
            $patientCount = is_array($patientRef) ? count($patientRef) : 0;
            
            if($patientRef){
                foreach($patientRef as $key => $patient){
                    $patientId = $patient['patientID'];
                    $userRef = $this->database->getReference('administrator/users/' . $patientId)->getSnapshot()->getValue();
                    if($userRef){
                        $patientData[] = [
                            'id' => $patientId,
                            'name' => $userRef['full_name'],
                            'email' => $userRef['email'],
                            'phone'=> $userRef['phone_number'],
                            'conditions' => $userRef['conditions'], 
                        ];
                    }
                }
            }
           return view('doctor/patientlist', [
            'patientData' => $patientData,
            'doctorData' => $doctorData,
            'patientCount' =>  $patientCount,
        ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function viewAppointments(){
        if(Session::get('user') === 'doctor'){
            $id = Session::get('id');
            $docData = $this->database->getReference('administrator/doctors/'. $id)->getSnapshot()->getValue();
            if($docData){
                $doctorData = [
                    'docID' => $id,
                    'name' => $docData['name'],
                    'prof' => $docData['profession'],
                    'pic' => isset($docData['profilePic']) ? $docData['profilePic'] : null,
                ];
            }

            $patientRef = $this->database->getReference('administrator/doctors/' . $id . '/mypatients/')->getSnapshot()->getValue();

            $patientData = [];

            if($patientRef){
                foreach($patientRef as $key => $patient){
                    $patientId = $patient['patientID'];
                    $userRef = $this->database->getReference('administrator/users/' . $patientId)->getSnapshot()->getValue();
                    if($userRef){
                        $patientData[] = [
                            'id' => $patientId,
                            'name' => $userRef['full_name'],
                        ];
                    }
                }
            }

            $appointmentsRef = $this->database->getReference('administrator/doctors/' . $id  . '/scheduled_appointments/')->getSnapshot()->getValue();

            $appointments = [];

            if($appointmentsRef){
                foreach($appointmentsRef as $key => $appointment){
                    if(strtotime($appointment['appointmentDate']) < time()) {
                        $this->database->getReference('administrator/doctors/' . $id . '/scheduled_appointments/' . $key)->remove();
                    }
                    else{   
                        $appointments[] = [
                        'aptID' => $key,
                        'date' => $appointment['appointmentDate'],
                        'start' => $appointment['appointmentStartTime'],
                        'end' => $appointment['appointmentEndTime'],
                        'name'=> $appointment['appointmentPatient'],
                        'title' => $appointment['appointmentTitle'],
                        'color' => $appointment['color'],
                    ];
                    }
                }
            }
        return view('doctor/appointments', [
            'doctorData' => $doctorData,
            'patientData' => $patientData,
            'appointments' => $appointments,
        ]);
        }
        else{
            return redirect()->route('login');
        }   
    }

    public function addAppointments(Request $request){
        if(Session::get('user') === 'doctor'){
            $docID = Session::get('id');
            $aptSubject = $request->input('input-details');
            $aptDate = $request->input('input-date');
            $aptStartTime = $request->input('input-starttime');
            $aptEndTime = $request->input('input-endtime');
            $aptColor = $request->input('color-indicator');
            $aptChosenPatient = $request->input('selected-user');
            $aptPatientID = $request->input('appoint-patientID');

            $appointmentRef = $this->database->getReference('administrator/doctors/' . $docID . '/scheduled_appointments/')->getSnapshot()->getValue();
          
            if($appointmentRef){
                forEach($appointmentRef as $key => $apt){
                    if(isset($apt['appointmentDate'], $apt['appointmentStartTime'], $apt['appointmentEndTime'])){
                        if($apt['appointmentDate'] === $aptDate){
                            $existingStart = strtotime($apt['appointmentStartTime']);
                            $existingEnd =strtotime($apt['appointmentEndTime']);
                            $newStart = strtotime($aptStartTime);
                            $newEnd = strtotime($aptEndTime);

                            if($newStart < $existingEnd && $newEnd > $existingStart){
                                return back()->with('error', 'It seems that your chosen schedule is already occupied!');
                            }
                        }
                        else{
                              $appointmentData = [
                                'appointmentTitle' => $aptSubject,
                                'appointmentDate' => $aptDate,
                                'appointmentStartTime' => $aptStartTime,
                                'appointmentEndTime' => $aptEndTime,
                                'color' => $aptColor,
                                'appointmentPatient' =>  $aptChosenPatient,
                                'appointmentUserId' => $aptPatientID,
                            ];
            

                            $this->database->getReference('administrator/doctors/' . $docID . '/scheduled_appointments/')->push($appointmentData);
                            return redirect()->route('viewAppointments')->with('success', 'Your Appointment has been saved!');
                        }
                    }
                }
            }
            else{
                 $appointmentData = [
                                'appointmentTitle' => $aptSubject,
                                'appointmentDate' => $aptDate,
                                'appointmentStartTime' => $aptStartTime,
                                'appointmentEndTime' => $aptEndTime,
                                'color' => $aptColor,
                                'appointmentPatient' =>  $aptChosenPatient,
                                'appointmentUserId' => $aptPatientID,
                            ];
            

                            $this->database->getReference('administrator/doctors/' . $docID . '/scheduled_appointments/')->push($appointmentData);
                            return redirect()->route('viewAppointments')->with('success', 'Your Appointment has been saved!');
            }
          
        }
        else{
            return redirect()->route('login');
        }
    }

    public function removeAppointment($id){
        if(Session::get('user') === 'doctor'){
            $docID = Session::get('id');
            $this->database->getReference('administrator/doctors/' . $docID . '/scheduled_appointments/' . $id)->remove();
            return redirect()->route('viewAppointments');
        }
        else{
            return redirect()->route('login');
        }
    }

}


 