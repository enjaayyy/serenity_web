<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\DateTime;

class RegisterController extends Controller
{
    public function __construct(Database $database, Storage $storage){
        $this->database = $database;
        $this->tablename = 'administrator/doctorRequests';
        $this->storage= $storage;
        $this->bucket = $this->storage->getBucket();
    }

    private function availableProfs(){
        $professions = ["Psychologist", "Psychoanalyst", "Psychometrician", "Councilor", "Therapist", "Nurse", "Social Workers", "Dentist"];
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
                        'licenseIssued' => $request->licenseissued,
                        'licenseExpired' => $request->licenseexpired,
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
        try{
            if (!$request->hasFile('ocr-image')) {
                return response()->json(['error' => 'No file uploaded.'], 400);
            }
            $image = $request->file('ocr-image');
            $path = $image->store('ocr-uploads');
    
            $fullPath = storage_path("app/{$path}");
    
            $output = shell_exec("tesseract " . escapeshellarg($fullPath) . " stdout");
    
            $text = trim($output);

            preg_match('/\b\d{7}\b/', $text, $licenseData);
            preg_match('/\b(Psychologist|Psychoanalyst|Psychometrician|Councilor|Therapist|Nurse|Counselors|Social Workers|Dentist)\b/i', $text, $professionData);
            preg_match('/\b\d{2}\b/', $text, $ageData);
            preg_match('/\b(Male|Female)\b/i', $text, $genderData);
            preg_match_all('/\b(0[1-9]|1[0-2])\/([0-2][0-9]|3[01])\/\d{4}\b/', $text, $dates);

            $today = new \DateTime();

            $dateIssued = null;
            $dateExpired = null;

            foreach($dates[0] as $dateStr){
                $date = \DateTime::createFromFormat('m/d/Y', $dateStr);

                if(!$date) continue;

                if($date <= $today){
                    $dateIssued = $date->format('Y-m-d');
                }
                else{
                    $dateExpired = $date->format('Y-m-d');
                }

            }

            return response()->json([
                'licenseNumber' => $licenseData,
                'rawText' => $text,
                'profession' => $professionData,
                'age' => $ageData,
                'gender' => $genderData,
                'issued' => $dateIssued,
                'expired' => $dateExpired,

            ]);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
    }   


 
}
