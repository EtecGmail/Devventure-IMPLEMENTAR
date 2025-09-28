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
        Schema::create('respostas_alunos', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('aluno_id')->constrained('aluno')->onDelete('cascade');
        // Chave estrangeira que liga a resposta a uma pergunta.
        $table->foreignId('pergunta_id')->constrained()->onDelete('cascade');
        // O texto da resposta que o aluno digitou/selecionou.
        $table->text('resposta');
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
        Schema::dropIfExists('resposta_alunos');
    }
};
