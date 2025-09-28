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
    
    Schema::create('aula_aluno', function (Blueprint $table) {
        $table->id();
        $table->foreignId('aluno_id')->constrained('aluno')->onDelete('cascade');
        $table->foreignId('aula_id')->constrained()->onDelete('cascade');
        
        
        $table->integer('segundos_assistidos')->default(0);
        $table->enum('status', ['nao_iniciado', 'concluido'])->default('nao_iniciado');
        $table->timestamp('concluido_em')->nullable();
        
        $table->timestamps();

        
        $table->unique(['aula_id', 'aluno_id']);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aluno_aula');
    }
};
