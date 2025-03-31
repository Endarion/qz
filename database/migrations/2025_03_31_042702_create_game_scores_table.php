<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_scores', static function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('score');
            $table->unsignedInteger('rank');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_scores');
    }
};