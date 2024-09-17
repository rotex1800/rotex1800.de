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
        Schema::table('menu_entries', function (Blueprint $table) {
            $table->enum('type', ['page', 'index'])->default('page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_entries', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
