<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewslettersTable extends Migration
{
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->text('email');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('newsletters');
    }
}
