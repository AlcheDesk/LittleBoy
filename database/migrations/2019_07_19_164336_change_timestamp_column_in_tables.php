<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTimestampColumnInTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	// public function up() {
	// 	// normal table columns
	// 	DB::statement("UPDATE activity_log SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE activity_log SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE activity_log MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE activity_log MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE invites SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE invites SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE invites MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE invites MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE login_record SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE login_record SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE login_record MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE login_record MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE media SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE media SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE media MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE media MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE oauth_access_tokens SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE oauth_access_tokens SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE oauth_access_tokens MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE oauth_access_tokens MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE oauth_clients SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE oauth_clients SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE oauth_clients MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE oauth_clients MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE oauth_personal_access_clients SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE oauth_personal_access_clients SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE oauth_personal_access_clients MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE oauth_personal_access_clients MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE permissions SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE permissions SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE permissions MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE permissions MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE roles SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE roles SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE roles MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE roles MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	DB::statement("UPDATE users SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("UPDATE users SET updated_at = CURRENT_TIMESTAMP() WHERE updated_at = null");
	// 	DB::statement("ALTER TABLE users MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");
	// 	DB::statement("ALTER TABLE users MODIFY COLUMN updated_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	//special table columns
	// 	DB::statement("UPDATE password_resets SET created_at = CURRENT_TIMESTAMP() WHERE created_at = null");
	// 	DB::statement("ALTER TABLE password_resets MODIFY COLUMN created_at timestamp(6) DEFAULT CURRENT_TIMESTAMP(6)");

	// 	Schema::table('tables', function (Blueprint $table) {
	// 		//
	// 	});
	// }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('tables', function (Blueprint $table) {
			//
		});
	}
}
