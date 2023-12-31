<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('card_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreignId('card_id')
                ->references('id')
                ->on('cards')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_player');
    }
};
