<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct(Database $database){
        $this->database = $database;
    }

    public function authenticate(Request $request){
        $adminPass = $this->database->getReference('administrator/-O2L6zFJDt4CnRFXGKeA/adminPass')->getValue();
        $adminUser = $this->database->getReference('administrator/-O2L6zFJDt4CnRFXGKeA/adminUser')->getValue();

        $userInput = $request->input('email');
        $userPass = $request->input('pass');

        if($userInput == $adminUser && $adminPass == $userPass){
            Session::put('user', 'admin');
            return true;
        }
        else{
            return false;
        }
    }

    public function authenticateDoctor(Request $request){
        $view = $this->database->getReference('administrator/doctors/');
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $doctorname = $request->input('email');
        $doctorpass = $request->input('pass');

        foreach($data as $id => $doctor){
            if($doctorname == $doctor['email'] && $doctorpass == $doctor['pass']){
                Session::put('user', 'doctor');
                Session::put('id', $id);
                return $id;
            }
        }
        return false;
        
    }

    public function final(Request $request){
    if($this->authenticate($request)){
        return redirect()->route('adminDashboard');
    }
    else if($refkey = $this->authenticateDoctor($request)){
        return redirect()->route('docDashboard');
    }
    else{
        return response("false");
    }
    }

    public function logout(Request $request){
        Session::flush();
        return redirect()->route('login');
    }
    
}
