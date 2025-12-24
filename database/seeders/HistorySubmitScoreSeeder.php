<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HistorySubmitScores;
use App\Models\User;

class HistorySubmitScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id');

        foreach ($users as $userId) {
            for ($level = 1; $level <= rand(3, 10); $level++) {
                HistorySubmitScores::create([
                    'user_id' => $userId,
                    'level' => $level,
                    'score' => rand(100, 2000)
                ]);
            }
        }
    }
}
