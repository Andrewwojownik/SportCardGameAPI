<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('duels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_one_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            $table->foreignId('player_two_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            $table->integer('last_finished_round');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duels');
    }
};
