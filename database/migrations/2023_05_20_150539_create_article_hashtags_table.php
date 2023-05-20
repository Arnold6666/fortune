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
        Schema::create('article_hashtags', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained('articles');
            $table->foreignId('hashtag_id')->constrained('hashtags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_hashtags');
    }
};
