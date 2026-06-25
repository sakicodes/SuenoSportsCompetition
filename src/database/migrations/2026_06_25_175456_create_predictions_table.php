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
        Schema::create('predictions', function (Blueprint $table) {
		$table->id();
		$table->foreignId('user_id')->constrained()->cascadeOnDelete();
		$table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();
		$table->foreignId('predicted_team_id')->constrained('teams');
		$table->integer('points_spent')->default(0);
		$table->integer('points_awarded')->nullable();
		$table->enum('status', ['PENDING', 'CORRECT', 'INCORRECT'])->default('PENDING');
		$table->timestamps();

		$table->unique(['user_id', 'match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
