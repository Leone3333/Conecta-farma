<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postos_saude', function (Blueprint $table) {
            $table->bigIncrements('id_posto'); // Cria 'id_postos' como a chave primária            
            $table->string('nome');
            $table->string('endereco');
            $table->string('telefone')->nullable(); // Exemplo: campo pode ser opcional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postos_saude');
    }
};
