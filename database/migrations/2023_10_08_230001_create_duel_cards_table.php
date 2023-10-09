<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('duel_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duel_id')
                ->references('id')
                ->on('duels')
                ->onDelete('cascade');
            $table->foreignId('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            $table->foreignId('card_id')
                ->references('id')
                ->on('cards')
                ->onDelete('cascade');
            $table->integer('used_in_round')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duel_cards');
    }
};
