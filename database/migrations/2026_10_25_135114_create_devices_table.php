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
		Schema::create('devices', function (Blueprint $table) {
			$table->id();
			$table->uuid();
			$table->foreignId('board_id')->constrained()
				->cascadeOnDelete()->cascadeOnUpdate()
				//
			;

			$table->unsignedBigInteger('internal_id');
			$table->string('name');
			$table->boolean('is_passive');
			$table->boolean('is_reportable');
			$table->integer('type');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('devices');
	}
};
