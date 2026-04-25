<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->integer('home_score');
            $table->integer('away_score');
            $table->decimal('bet_amount', 10, 2)->nullable();
            $table->integer('points')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'game_id', 'group_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
