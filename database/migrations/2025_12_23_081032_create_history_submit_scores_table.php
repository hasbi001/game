<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_submit_scores', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained()->index();
            $table->integer('level')->index();
            $table->integer('score');
            $table->timestamps();

            $table->index(['user_id','level']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_submit_scores');
    }
};
