<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->nullable(false);
            $table->string('token')->nullable(false);
            $table->timestamp('created_at')->nullable(false)->default('CURRENT_TIMESTAMP');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
