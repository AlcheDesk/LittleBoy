<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginRecordTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('login_mode', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('mode_name');
		});

		Schema::create('login_record', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('uuid');
			$table->string('ip');
			$table->string('location');
			//$table->string('login_mode')->default('邮箱密码');
			$table->unsignedBigInteger('login_mode_id');
			$table->foreign('login_mode_id')
				->references('id')
				->on('login_mode')
				->onDelete('cascade');

			$table->string('timestamp');
			$table->string('token');
			$table->string('token_duration');
			$table->timestampsTz();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('login_record');
		Schema::dropIfExists('login_mode');
	}
}
