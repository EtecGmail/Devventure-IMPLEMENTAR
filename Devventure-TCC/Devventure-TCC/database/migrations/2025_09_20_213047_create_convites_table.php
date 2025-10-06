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
         Schema::create('convites', function (Blueprint $table) {
        $table->id();
        $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
        $table->foreignId('aluno_id')->constrained('aluno')->onDelete('cascade');
        $table->foreignId('professor_id')->constrained('professor')->onDelete('cascade');
        $table->string('status')->default('pendente'); // pendente, aceito, recusado
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
        Schema::dropIfExists('convites');
    }
};
