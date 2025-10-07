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
    Schema::create('aluno_turma', function (Blueprint $table) {
        
        $table->foreignId('aluno_id')->constrained('aluno')->onDelete('cascade');

        
        $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');

        $table->primary(['aluno_id', 'turma_id']);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aluno_turma');
    }
};
