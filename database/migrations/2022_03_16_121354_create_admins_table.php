<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigIncrements('display_id')->comment('表示用ID');
            $table->string('name')->nullable()->comment('氏名');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('password')->comment('パスワード');
            $table->rememberToken();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unique('display_id');
            $table->dropPrimary();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
