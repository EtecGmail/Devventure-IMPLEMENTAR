<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('aluno', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('ra')->unique();
            $table->string('semestre');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar')->nullable();
            $table->string('telefone')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('status')->default('ativo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('aluno');
    }
};
