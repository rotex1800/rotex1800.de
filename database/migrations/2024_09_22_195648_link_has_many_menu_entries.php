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
        Schema::create('link_menu_entry', function (Blueprint $table) {
            $table->bigInteger('link_id')->nullable();
            $table->bigInteger('menu_entry_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('link_menu_entry', function (Blueprint $table) {
            $table->drop();
        });
    }
};
