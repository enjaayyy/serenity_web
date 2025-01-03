<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;

class PatientController extends Controller
{
    public function __construct(Database $database, Storage $storage){

        $this->database = $database;
        $this->storage = $storage;
        $this->bucket = $this->storage->getBucket();

    }

    public function viewPatientDetails($id){
        $userRef = $this->database->getReference('administrator/users/' . $id);
        $userSnapshot = $userRef->getSnapshot();
        $userData = $userSnapshot->getValue();

        if($userData){
            $userDetails = [
                'condition' => $userData['conditions'],
                'email' => $userData['email'],
                'name' => $userData['full_name'],
                'num' => $userData['phone_number'],
                'id' => $id,
            ];
        }

        $myDocRef = $this->database->getReference('administrator/users/' . $id . '/' . 'mydoctor');
        $myDocSnap = $myDocRef->getSnapshot();
        $myDocData = $myDocSnap->getValue();

        $docData = [];

        if($myDocData){
            foreach($myDocData as $doctor){
                $doctorID = $doctor['doctorId'];
                $doctorRef = $this->database->getReference('administrator/doctors/'. $doctorID);
                $doctorSnap = $doctorRef->getSnapshot();
                $doctorData = $doctorSnap->getValue();

                if($doctorData){
                    $docData[] = [
                        'id' => $doctorID,
                        'name' => $doctorData['name'],
                        'profile' => isset($doctorData['profilePic']) ? ($doctorData['profilePic']) : null,
                        'status' => $doctor['status'],
                    ];
                }
            }
        }

        // $answersRef = $this->database->getReference('administrator/users/' . $id .  '/' . 'all_answers');
        // $answerSnap = $answersRef->getSnapshot();
        // $answerData = $answerSnap->getValue();

        // $answers_arr = [];

        // if($answerData){
        //     foreach($answerData as $answers){
        //         $formattedTime = date('M, d', strtotime($answers['timestamp']));
        //         $answers_arr[] = [
        //             'Time' => $formattedTime,
        //             'Value' => $answers['total_value'],
        //         ];
        //     }
        // }


        return view('administrator.patientDetails', [
            'userDetails' => $userDetails,
            'docData' => $docData,
            // 'data' => json_encode($answers_arr),
        ]);
    }

    public function patientProfile($id){
        if(Session::get('user') == 'doctor'){
            $docID = Session::get('id');
            $doctorRef = $this->database->getReference('/administrator/doctors/' . $docID);
            $docSnap = $doctorRef->getSnapshot();
            $docVal = $docSnap->getValue();

            if($docVal){
                $doctorData = [
                    'docID' => $docID,
                    'name' => $docVal['name'],
                    'pic' => isset($docVal['profilePic']) ? $docVal['profilePic'] : null,
                    'prof' => $docVal['profession'],
                ];
            }

            $patientRef = $this->database->getReference('/administrator/users/'. $id);
            $patientSnap = $patientRef->getSnapshot();
            $patientData = $patientSnap->getValue();

            

            if($patientData){
                $patientDetails = [
                    'patientID' => $id,
                    'condition' => $patientData['conditions'],
                    'email' => $patientData['email'],
                    'name' => $patientData['full_name'],
                    'num' => $patientData['phone_number'],
                ];
            }

        $answersRef = $this->database->getReference('administrator/users/' . $id .  '/' . 'all_answers');
        $answerSnap = $answersRef->getSnapshot();
        $answerData = $answerSnap->getValue();

        $answers_arr = [];

        if($answerData){
            foreach($answerData as $answers){
                $formattedTime = date('M, d', strtotime($answers['timestamp']));
                $answers_arr[] = [
                    'Time' => $formattedTime,
                    'Value' => $answers['total_value'],
                ];
            }
        }
        $chatID = $docID . "-" . $id;
        $chatRef = $this->database->getReference('administrator/chats/'. $chatID);
        $chatSnap = $chatRef->getSnapshot();
        $chatData = $chatSnap->getValue();

        $messages = [];

        if($chatData){
            foreach($chatData as $message){
                $messages[] = [
                'sender' => $message['senderId'],
                'message' => $message['message'],
                'timestamp' => $message['timestamp'],   
                ];
            }
        }

            return view('doctor.patientProfile', [
                'patientDetails' => $patientDetails,
                'doctorData' => $doctorData,
                'data' => json_encode($answers_arr),
                'messages' => $messages,
                'chatID' => $chatID,
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

}
