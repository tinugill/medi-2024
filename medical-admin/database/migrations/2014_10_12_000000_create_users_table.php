<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('uid');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->enum('type', ['User', 'Doctor', 'Hospital', 'Hospitalstaff', 'Pharmacy', 'Lab', 'Bloodbank', 'Nursing', 'Dealer'])->default('User');
            $table->string('password');
            $table->string('my_referal');
            $table->string('joined_from');
            $table->enum('is_active', [0, 1])->comment('0 not active 1 active')->default(0);
            $table->enum('is_verified', [0, 1])->comment('0 not verified 1 verified')->default(0);
            $table->enum('is_deleted', [0, 1])->comment('0 not deleted 1 deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
