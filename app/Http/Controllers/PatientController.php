<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;
use Illuminate\Support\Facades\Http;
use Pusher\Pusher;
use TaylanUnutmaz\AgoraTokenBuilder\RtcTokenBuilder;


class PatientController extends Controller
{
    public function __construct(Database $database, Storage $storage){

        $this->database = $database;
        $this->storage = $storage;
        $this->bucket = $this->storage->getBucket();

    }

    public function viewPatientDetails($id){
        $userRef = $this->database->getReference('administrator/users/' . $id)->getSnapshot()->getValue();
        if($userRef){
            $formattedDate = date("F d, Y", strtotime($userRef['birthdate']));
            $userDetails = [
                'condition' => $userRef['conditions'],
                'email' => $userRef['email'],
                'name' => $userRef['full_name'],
                'num' => $userRef['phone_number'],
                'id' => $id,
                'birthdate' => $formattedDate,
            ];
        }

        $myDocRef = $this->database->getReference('administrator/users/' . $id . '/' . 'mydoctor')->getSnapshot()->getValue();
        $docData = [];
        if($myDocRef){
            foreach($myDocRef as $doctor){
                $doctorID = $doctor['doctorId'];
                $doctorRef = $this->database->getReference('administrator/doctors/'. $doctorID)->getSnapshot()->getValue();
               

                if($doctorRef){
                    $docData[] = [
                        'id' => $doctorID,
                        'name' => $doctorRef['name'],
                        'profile' => isset($doctorRef['profilePic']) ? ($doctorRef['profilePic']) : null,
                        'status' => $doctor['status'],
                    ];
                }
            }
        }


        return view('administrator.patientDetails', [
            'userDetails' => $userDetails,
            'docData' => $docData,
        ]);
    }

    public function patientProfile($id){
        if(Session::get('user') == 'doctor'){
            $docID = Session::get('id');
            $doctorRef = $this->database->getReference('/administrator/doctors/' . $docID)->getSnapshot()->getValue();

            if($doctorRef){
                $doctorData = [
                    'docID' => $docID,
                    'name' => $doctorRef['name'],
                    'pic' => isset($doctorRef['profilePic']) ? $doctorRef['profilePic'] : null,
                    'prof' => $doctorRef['profession'],
                ];
            }

            $patientRef = $this->database->getReference('/administrator/users/'. $id)->getSnapshot()->getValue();
            
            if($patientRef){
                $formattedDate = date("F d, Y", strtotime($patientRef['birthdate']));
                $conditionCount = count($patientRef['conditions']);
                $notesRef = $this->database->getReference('/administrator/users/' . $id . '/doctorNotes')->getSnapshot()->getValue();

                $notesArray = [];

                if($notesRef){
                    foreach($notesRef as $noteid => $notes) {
                        $formattedNotesDate = date("F d, Y", strtotime($notes['dateFiled']));
                        $notesArray[] = [
                            'id' => $noteid,
                            'details' => $notes['noteDetails'],
                            'timestamp' => $formattedNotesDate,
                        ];
                    }
                }
                $patientDetails = [
                    'patientID' => $id,
                    'condition' => $patientRef['conditions'],
                    'email' => $patientRef['email'],
                    'name' => $patientRef['full_name'],
                    'num' => $patientRef['phone_number'],
                    'sex' => $patientRef['sex'],
                    'username' => $patientRef['username'],
                    'bday' => $formattedDate,
                    'pic' => $patientRef['profile_image'] ? $patientRef['profile_image'] : null, 
                    'conditionCount' => $conditionCount,
                    'notes' => isset($notesArray) ? $notesArray : [],
                    'answer' => isset($patientRef['all_answers']) ? $patientRef['all_answers'] : null,
                ];
            }

        $chatID = $docID . "-" . $id;
        $chatRef = $this->database->getReference('administrator/chats/'. $chatID)->getSnapshot()->getValue();

        $messages = [];

        if($chatRef){
            foreach($chatRef as $message){
                $messages[] = [
                'sender' => $message['senderId'] ? $message['senderId'] : null,
                'message' => $message['message'] ? $message['message'] : null,
                'timestamp' => $message['timestamp'] ? $message['timestamp'] : null,   
                ];
            }
        }

            return view('doctor.patientProfile', [
                'patientDetails' => $patientDetails,
                'doctorData' => $doctorData,
                'messages' => $messages,
                'chatID' => $chatID,
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function reportPatient(Request $request, $id){
        if(Session::get('user') == 'doctor'){
            $docID = Session::get('id');
            
            $chosenReasons = $request->input('choices', []);
            $details = $request->input('reason-details');

            if(empty($chosenReasons)){
                $reportData = [
                    'reporterId' => $docID,
                    'reportedId' => $id,
                    'reportDetails' => $details,
                    'timestamp' => date('Y-m-d H:i:s'),
                ];

                $this->database->getReference('administrator/reports')->push($reportData);

                return redirect()->route('viewPatients');
            } 
            else {
                $reasons = implode(',',  $chosenReasons);
                $reasonsAndDetails = $reasons . $details;

                $reportData = [
                    'reporterId' => $docID,
                    'reportedId' => $id,
                    'reportDetails' => $reasonsAndDetails,
                    'timestamp' => date('Y-m-d H:i:s'),
                ];

                $this->database->getReference('administrator/reports')->push($reportData);
                return redirect()->route('viewPatients');
            }

        }
        else{
            return redirect()->route('login');
        }
    }

    public function addNote(Request $request, $id){
        if(Session::get('user') === 'doctor'){
            $docID = Session::get('id');
            $notesDetails = $request->input('notes-data');

            if($notesDetails){
                $notesData = [
                    'doctorID' => $docID,
                    'dateFiled' => date('Y-m-d H:i:s'),
                    // 'dateFiled' => '2025-04-13 08:26:17',
                    'noteDetails' => $notesDetails,
                ];
                $this->database->getReference('administrator/users/'. $id . '/doctorNotes/')->push($notesData);
                return redirect()->route('viewPatients');

            }
        }
        else{
            return redirect()->route('login');
        }
    }

}
