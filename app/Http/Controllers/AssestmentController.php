<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AssestmentController extends Controller
{
    public function send(Request $request)
    {
        $timestamp = now()->timestamp * 1000;
        $nonce = Str::random(16);
        $secret = 'ABC123xyz';

        $signature = hash('sha256', $nonce . $timestamp . $secret);
        $response = Http::withHeaders([
            'X-Nonce' => $nonce,
            'X-API-Signature' => $signature,
        ])->post(
            'https://unisync.alphagames.my.id/api/assessment',
            [
                'timestamp' => $timestamp
            ]
        );

        return response()->json([
            'request' => [
                'timestamp' => $timestamp,
                'nonce' => $nonce,
                'signature' => $signature
            ],
            'response' => $response->json(),
            'status' => $response->status()
        ]);
    }
}
