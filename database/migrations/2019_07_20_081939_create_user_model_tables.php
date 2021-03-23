<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserModelTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('billing_activities', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->unique();
			$table->bigInteger('account_id');
			$table->string('billing_activity_type');
			$table->double('price');
			$table->double('quantity');
			$table->double('total_amount');
			$table->string('log');
			$table->timestampsTz();

		});

		Schema::create('bills', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->unique();
			$table->bigInteger('account_id');
			$table->string('billing_activities');
			$table->double('total_amount');
			$table->string('log');
			$table->timestampsTz();

		});

		Schema::create('accounts', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->unique();
			$table->string('name')->unique()->nullable(false);
			$table->string('account_level')->nullable(false);
			$table->dateTimeTz('expirated_at')->nullable(false);
			$table->string('description')->nullable(true);
			$table->timestampsTz();
		});

		Schema::create('memberships', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->unique();
			$table->string('name')->unique()->nullable(false);
			$table->bigInteger('role_id')->nullable(false);
			$table->string('membership_email')->nullable();
			$table->string('membership_phone_number')->nullable();
			$table->dateTimeTz('expirated_at')->nullable(false);
			$table->string('description');
			$table->timestampsTz();
		});

		Schema::create('bill_has_billing_activity', function (Blueprint $table) {
			$table->unsignedInteger('bill_id');
			$table->unsignedInteger('billing_activity_id');

			$table->foreign('bill_id')
				->references('id')
				->on('bills');

			$table->foreign('billing_activity_id')
				->references('id')
				->on('billing_activities');

			$table->primary(['bill_id', 'billing_activity_id']);

		});

		Schema::create('account_has_bill', function (Blueprint $table) {
			$table->unsignedInteger('account_id');
			$table->unsignedInteger('bill_id');

			$table->foreign('account_id')
				->references('id')
				->on('accounts');

			$table->foreign('bill_id')
				->references('id')
				->on('bills');

			$table->primary(['account_id', 'bill_id']);

		});

		Schema::create('account_has_membership', function (Blueprint $table) {
			$table->unsignedInteger('account_id');
			$table->unsignedInteger('membership_id');

			$table->foreign('account_id')
				->references('id')
				->on('accounts');

			$table->foreign('membership_id')
				->references('id')
				->on('memberships');

			$table->primary(['account_id', 'membership_id']);

		});

		Schema::create('user_has_membership', function (Blueprint $table) {
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('membership_id');

			$table->foreign('user_id')
				->references('id')
				->on('users');

			$table->foreign('membership_id')
				->references('id')
				->on('memberships');

			$table->primary(['user_id', 'membership_id']);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('bill_has_billing_activity');
		Schema::dropIfExists('account_has_bill');
		Schema::dropIfExists('account_has_membership');
		Schema::dropIfExists('user_has_membership');
		Schema::dropIfExists('memberships');
		Schema::dropIfExists('accounts');
		Schema::dropIfExists('bills');
		Schema::dropIfExists('billing_activities');
	}
}
