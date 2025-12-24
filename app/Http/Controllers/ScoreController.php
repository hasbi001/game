<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\HistorySubmitScores;
use App\Http\Requests\SubmitScoreRequest;

class ScoreController extends Controller
{
    public function submit(SubmitScoreRequest $request)
    {

        HistorySubmitScores::create($request->validated());
        Cache::tags(['leaderboard'])->flush();

        return response()->json([
            'message' => 'Score submitted successfully'
        ]);
    }
}
