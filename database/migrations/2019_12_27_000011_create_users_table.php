<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('usuario');
            $table->string('email');
            $table->string('password');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('departamento_id');
            $table->tinyInteger('activo')->nullable();
            $table->rememberToken();

            $table->index(["role_id"], 'fk_user_role1_idx');

            $table->index(["departamento_id"], 'fk_user_departamento1_idx');

            $table->unique(["email"], 'users_email_unique');
            $table->nullableTimestamps();


            $table->foreign('role_id', 'fk_user_role1_idx')
                ->references('id')->on('roles')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('departamento_id', 'fk_user_departamento1_idx')
                ->references('id')->on('departamentos')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
