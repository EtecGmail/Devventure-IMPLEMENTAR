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
    Schema::create('aluno_aula', function (Blueprint $table) {
        $table->id();
        $table->foreignId('aluno_id')->constrained()->onDelete('cascade');
        $table->foreignId('aula_id')->constrained()->onDelete('cascade');
        $table->integer('segundos_assistidos')->default(0);
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
        Schema::dropIfExists('aluno_aula');
    }
};
