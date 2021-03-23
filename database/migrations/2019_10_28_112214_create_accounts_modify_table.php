<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsModifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('industry')->nullable();//行业
            $table->string('position')->nullable();//职位
            $table->uuid('user_uuid');//用户uuid，一个用户可对应多个账号，但这多个账号之间的数据不互通，如有多个，登录进入时需选择
            $table->integer('tenant_id')->unique();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
