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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('rating')->comment('1-5 stars'); 

            $table->text('content');

            $table->foreignId('event_id');
            $table->foreignId('user_id'); // ✅ new
            //hier hosts entfernt

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) { // ✅ new
            $table->dropColumn(['user_id', 'rating']);
            // $table->string('host'); // nur falls du oben droppst
        });
    }
};
