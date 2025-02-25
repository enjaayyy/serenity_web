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
                    'questions' => isset($data['activeQuestionnaires']) ? $data['activeQuestionnaires'] : null,
                    'creds' => $data['credentials'],
                    'templates' => isset($data['savedQuestionnaires']) ? $data['savedQuestionnaires'] : null,
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
                $doctorData = [
                    'id' => $id,
                    'name' => $docData['name'],
                    'prof' => $docData['profession'],
                    'pic' => isset($docData['profilePic']) ? $docData['profilePic'] : null,
                ];
            }

            $appointmentData = $this->database->getReference('administrator/doctors/'. $id . '/Appointments/')->getSnapshot()->getValue();
            
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
                $doctorData = [
                    'id' => $id,
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
        ]);
        }
        else{
            return redirect()->route('login');
        }
    }
}


