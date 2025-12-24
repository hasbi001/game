<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $username = $request->get('username');

        $cacheKey = "leaderboard:$page:" . ($username ?? 'all');

        return Cache::tags(['leaderboard'])
            ->remember($cacheKey, 60, function () use ($username) {

                $sql = "
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY total_score DESC) AS ranking,
                        username,
                        last_level,
                        total_score
                    FROM (
                        SELECT
                            u.username,
                            MAX(h.level) AS last_level,
                            SUM(h.max_score) AS total_score
                        FROM (
                            SELECT user_id, level, MAX(score) AS max_score
                            FROM history_submit_scores
                            GROUP BY user_id, level
                        ) h
                        JOIN users u ON u.id = h.user_id
                        GROUP BY u.username
                    ) leaderboard
                ";

                if ($username) { 
                    $sql .= " WHERE username = ?";
                    return DB::select($sql, [$username]);
                }

                return DB::table(DB::raw("($sql) t"))
                    ->paginate(10);
            }); 
    }
}
