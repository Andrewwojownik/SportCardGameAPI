<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('duel_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_one_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            $table->integer('player_one_points');
            $table->foreignId('player_two_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            $table->integer('player_two_points');
            $table->foreignId('winner_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duel_histories');
    }
};
