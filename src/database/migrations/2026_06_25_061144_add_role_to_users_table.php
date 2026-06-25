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
        Schema::table('users', function (Blueprint $table) {
		$table->string('role')->default('USER')->after('password');
		$table->integer('current_points')->default(0)->after('role');
		$table->boolean('first_login')->default(true)->after('current_points');
		$table->boolean('active')->default(true)->after('first_login');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
		$table->dropColumn(['role', 'current_points', 'first_login', 'active']);
        });
    }
};
