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
        Schema::create('rounds', function (Blueprint $table) {
		$table->id();
		$table->foreignId('competition_id')->constrained()->cascadeOnDelete();
		$table->string('name');
		$table->integer('sequence');
		$table->integer('prediction_cost')->nullable();
		$table->integer('prediction_reward')->nullable();
		$table->dateTime('prediction_lock_datetime');
		$table->boolean('locked')->default(false);
		$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rounds');
    }
};
