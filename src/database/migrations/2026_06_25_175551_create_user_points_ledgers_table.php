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
        Schema::create('user_points_ledgers', function (Blueprint $table) {
		$table->id();
		$table->foreignId('user_id')->constrained()->cascadeOnDelete();
		$table->integer('amount');
		$table->enum('transaction_type', ['INITIAL_ALLOCATION', 'PREDICTION_COST', 'PREDICTION_REWARD', 'ADMIN_ADJUSTMENT']);
		$table->string('reference_type')->nullable(); // e.g., App\Models\Prediction
		$table->unsignedBigInteger('reference_id')->nullable(); // e.g., the prediction ID
		$table->string('notes')->nullable();
		$table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_points_ledgers');
    }
};
