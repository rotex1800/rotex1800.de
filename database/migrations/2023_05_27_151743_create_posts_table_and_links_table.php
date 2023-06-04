<?php

use App\Models\Post;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('checksum')->unique('posts_checksum_index');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('path')->index('links_path_index');
            $table->foreignIdFor(Post::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
        Schema::dropIfExists('posts');
    }
};
