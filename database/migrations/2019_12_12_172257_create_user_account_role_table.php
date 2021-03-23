<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('account_id');
            $table->integer('role_id');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE account_role ADD CONSTRAINT constraint_name UNIQUE KEY(user_id,account_id,role_id);");

        /*Artisan::call('db:seed',[
            '--class' => UserAccountRoleSeeder::class
        ]);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_role');
    }
}
