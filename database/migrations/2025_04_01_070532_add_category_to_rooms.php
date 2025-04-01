<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', static function (Blueprint $table) {
            $table->after('host_id', function ($table) {
                $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            });
        });
    }

    public function down(): void
    {
        Schema::table('rooms', static function (Blueprint $table) {
            $table->dropForeign('room_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
};
