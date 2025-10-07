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
        
    Schema::create('perguntas', function (Blueprint $table) {
        $table->id();
        // Chave estrangeira que liga a pergunta a um formulário específico.
        $table->foreignId('formulario_id')->constrained()->onDelete('cascade');
        $table->text('texto_pergunta');
        $table->string('tipo_pergunta')->default('texto_curto');
        // 'opcoes' guardará um JSON com as alternativas para perguntas de múltipla escolha.
        $table->json('opcoes')->nullable();
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
        Schema::dropIfExists('perguntas');
    }
};
