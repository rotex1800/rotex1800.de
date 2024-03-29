<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_entries', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('path');
            $table->string('menu');
            $table->integer('order');
            $table->string('checksum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_entries');
    }
};
