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
		Schema::create('boards', function (Blueprint $table) {
			$table->id();
			$table->uuid();
			$table->string('fingerprint', 64);
			$table->string('mac_address', 17);
			$table->string('name');
			$table->string('board');
			$table->string('hw_version');
			$table->string('sw_version');
			$table->boolean('is_trusted')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('boards');
	}
};
