<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Storage;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(Database $database, Storage $storage){
        $this->database = $database;
        $this->tablename = 'administrator/doctorRequests';
        $this->storage= $storage;
        $this->bucket = $this->storage->getBucket();
    }

    private function availableProfs(){
        $professions = ["Psychologists", "Psychoanalyst", "Psychometrician", "Councilor", "Therapist", "Psychiatric Nurse", "Counselors", "Social Workers"];
        return $professions;
    }

    public function register(Request $request){
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $fullname = $firstname . " " . $lastname;

        $doctorData = [
            'doctorFullname' => $fullname,
            'doctorEmail' => $request->email,
            'doctorPass' => $request->password,
        ];
        $register = $this->database->getReference($this->tablename)->push($doctorData);
        
        if($register){
            $key = $register->getKey();
            $request->session()->put('register_key', $key);
            return redirect('register-details');
        }   
        else{
            return redirect('home');
        }
    }
    

    public function registerDetailsView(){
        $professions = $this->availableProfs();
        return view('register-details', [
            'professions' => $professions
        ]);
    }

    public function registerDetails(Request $request){

        $key = $request->session()->get('register_key');

        if($request->hasFile('verifile')) {
            $files = $request->file('verifile');
            $links = [];

            foreach($files as $file) {
                $filename = $file->getClientOriginalName();
                $filepath = $file->getPathname();
                $StoragePath = 'credentials/' . $filename;

                $uploadedFile = $this->bucket->upload(
                    fopen($filepath, 'r'), [
                        'name' => $StoragePath
                    ]
                    );
                    $expiresAt = new \DateTime('+1 year');
                    $url = $uploadedFile->signedUrl($expiresAt);

                    $links[] = $url;
            }
                
                    $doctorData2 = [
                        'profession' => $request->profession,
                        'yearsOfService' => $request->service,
                        'gender' => $request->gender,
                        'age' => $request->age,
                        'medicalLicencse' => $request->license,
                        'workAddress' => $request->address,
                        'specialization' => $request->input('spec', []),
                        'credentials' => $links,
                    ];
                            
                    $success = $this->database->getReference($this->tablename . '/' . $key)->update($doctorData2);          
                             
                    if($success){
                        return redirect('login');
                    }       
        }
        else{
            return response('upload failed!!');
        }
    }


    public function imageToText(Request $request){
        
    }   
}
