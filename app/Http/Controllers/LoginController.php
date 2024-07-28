<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

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
            return true;
        }
        else{
            return false;
        }
    }

    public function authenticateDoctor(Request $request){
        
        $adminPass = $this->database->getReference('/administrator/doctorRequests/-O2Ycbx3FN7K-6YLjYbI/doctorPass')->getValue();
        $adminUser = $this->database->getReference('/administrator/doctorRequests/-O2YdDWJvxvy2VgaagEL/doctorEmail')->getValue();

        $userInput = $request->input('email');
        $userPass = $request->input('pass');

        if($userInput == $adminUser && $adminPass == $userPass){
            return true;
        }
        else{
            return false;
        }
    }

    public function final(Request $request){
    if($this->authenticate($request)){
        return redirect()->route('adminDashboard');
    }
    else if($this->authenticateDoctor($request)){
        return response("true");
    }
    else{
        return response("false");
    }
    }
    
}
