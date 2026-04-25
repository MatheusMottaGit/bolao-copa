<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('api_id')->unique()->nullable();
            $table->string('home_team');
            $table->string('away_team');
            $table->dateTime('starts_at');
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->string('status')->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
