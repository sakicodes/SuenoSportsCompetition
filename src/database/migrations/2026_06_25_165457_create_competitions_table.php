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
        Schema::create('competitions', function (Blueprint $table) {
		$table->id();
		$table->string('name');
		$table->text('description')->nullable();
		$table->enum('status', ['OPEN', 'CLOSED', 'COMPLETED'])->default('OPEN');
		$table->integer('default_prediction_cost')->default(1);
		$table->integer('default_prediction_multiplier')->default(2);
		$table->timestamps();
	});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
