<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Agora\TokenBuilder\RtcTokenBuilder;

class AccessTokenController extends Controller
{
     public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function generateToken(Request $request)
    {
        // Simulate generating Agora token (you should integrate the Agora RESTful API)
        $token = 'generated_agora_token';
        $channel = 'channel_' . rand(1000, 9999);
        $userId = $request->input('uid'); // Fetch from request

        // Save call data in Firebase
        $this->database->getReference('agoraChannels/' . $channel)->set([
            'channelName' => $channel,
            'userID' => $userId,
            'token' => $token,
        ]);

        // Return the token and channel for frontend
        return response()->json([
            'channel' => $channel,
            'token' => $token,
        ]);
    }
    
}
