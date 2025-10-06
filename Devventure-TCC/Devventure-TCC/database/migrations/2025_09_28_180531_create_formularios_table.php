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
    Schema::create('formularios', function (Blueprint $table) {
        $table->id();
        // Chave estrangeira que liga o formulário a uma aula específica.
        // Se a aula for deletada, o formulário também será.
        $table->foreignId('aula_id')->constrained()->onDelete('cascade');
        $table->string('titulo');
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
        Schema::dropIfExists('formularios');
    }
};
