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
   public function up(): void
{
    Schema::create('respostas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('aluno_id')->constrained('aluno')->onDelete('cascade');
        $table->foreignId('pergunta_id')->constrained('perguntas')->onDelete('cascade');
        $table->text('texto_resposta');
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
        Schema::dropIfExists('respostas');
    }
};
