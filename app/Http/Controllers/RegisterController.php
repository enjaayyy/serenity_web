<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Storage;

class RegisterController extends Controller
{
    public function __construct(Database $database, Storage $storage){
        $this->database = $database;
        $this->tablename = 'administrator/doctorRequests';
        $this->storage= $storage;
        $this->bucket = $this->storage->getBucket();
    }

    public function register(Request $request){

        $doctorData = [
            'doctorFullname' => $request->fullname,
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

    public function registerDetails(Request $request){
        
        $key = $request->session()->get('register_key');
        
        if($request->hasFile('verifile')) {
            $files = $request->file('verifile');
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


                    $filteredFile = str_replace(['.', '$', '#', '[', ']'], '_', $filename);

                    $doctorData2 = [
                        'profession' => $request->profession,
                        'yearsOfService' => $request->service,
                        'gender' => $request->gender,
                        'age' => $request->age,
                        'medicalLicencse' => $request->license,
                        'workAddress' => $request->address,
                        'specialization' => $request->spec,
                        'credentials' => $url,
                            ];
                            
                             $success = $this->database->getReference($this->tablename . '/' . $key)->update($doctorData2);                 
            }
                if($success){
            return redirect('login');
        }
        }
        else{
            return response('upload failed!!');
        }

        

       

        
        
    }

}
