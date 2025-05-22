<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbhistorialsTable extends Migration
{
    public function up()
    {
        Schema::create('dbhistorials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('area')->nullable()->default('NULL');
            $table->string('motivo')->nullable()->default('NULL');
            $table->string('fecha')->nullable()->default('NULL');
            $table->string('estado')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->integer('dbredb_id')->nullable()->default('NULL');
            $table->integer('dbrpadb_id')->nullable()->default('NULL');
            $table->integer('dbempresa_id')->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->integer('dbtramite_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbhistorials');
    }
}
