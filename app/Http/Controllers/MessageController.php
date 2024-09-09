<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;

class MessageController extends Controller
{
        
    public function __construct(Database $database){
        $this->database = $database;
    }
    
    public function sendMessage(Request $request){
        $chatID = $request->input('chatId');
        $message = $request->input('message');
        $sender = $request->input('sender');

        $formatTime = now()->toIso8601String();

        $messageRef = $this->database->getReference('administrator/chats/' . $chatID)->push();
        $messageRef->set([
        'senderId' => $sender,
        'message' => $message,
        'timestamp' => $formatTime,
        ]);
        return response()->json(['status' => 'Message sent']);
    }

}
