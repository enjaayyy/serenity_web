<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Contract\Database;

class FirebaseController extends Controller
{
        
    public function __construct(Database $firebaseService)
    {
        $this->firebaseService = $firebaseService;
        $this->tableName = 'administrator';
    }

    public function view(){
        return view('createAdminAcc');
    }

    public function testConnection(Request $request)
    {
        $adminData = [
            'adminUser' => $request->username,
            'adminPass' => $request->password,
        ];
        return $this->firebaseService->getReference($this->tableName)->push($adminData);
    }

    public function getvalue(){
        return $this->firebaseService->getReference('administrator/-O2L6zFJDt4CnRFXGKeA/adminPass')->getValue();
    }
}