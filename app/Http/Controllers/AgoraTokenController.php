<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AgoraTokenController extends Controller
{
    public function generateToken(Request $request)
    {
        $firebaseFunctionURl = "https://asia-southeast1-serenity-c800c.cloudfunctions.net/generateToken";

        $response = Http::post($firebaseFunctionURl, [
            'channelName' => $request->channelName,
            'patientId' => $request->patientId,
        ]);

        if($reponse->successful()) {
            return response()->json($response->json(), 200);
        }

        return response()->json([
            'error' => 'Failed to generate token',
            'details' => $response->body(),
        ], $response->status());
    }
}