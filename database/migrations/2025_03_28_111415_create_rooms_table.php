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
        Schema::create('rooms', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 5)->unique();
            $table->foreignId('host_id')->constrained();

            $table->unsignedTinyInteger('question_count')->default(10);
            $table->unsignedTinyInteger('answer_time')->default(15);

            // todo max_players?

            $table->boolean('is_public')->default(false);
            $table->string('password')->nullable();
            $table->boolean('is_ai')->default(false);

            $table->enum('status', ['waiting', 'playing', 'finished'])->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};