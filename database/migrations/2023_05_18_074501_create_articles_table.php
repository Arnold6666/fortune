<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('user_id')->constrained('users');
            $table->string('title', 255);
            $table->text('content');
            $table->string('image_path', 255)->nullable();
            $table->string('image_filename', 255)->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE articles ADD image MEDIUMBLOB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
