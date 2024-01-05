<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabtestcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labtestcategories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image', 500);
            $table->enum('is_deleted', ['0', '1'])->default(0)->comment('0 Not Delete 1 Deleted');

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
        Schema::dropIfExists('labtestcategories');
    }
}
