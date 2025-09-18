<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estoque', function (Blueprint $table) {
            $table->bigIncrements('id_estoque'); // Versão correta para nomear a chave primária
            
            // Chaves Estrangeiras
            $table->foreignId('id_postoFK')
                  ->constrained('postos_saude', 'id_posto')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreignId('id_medicamentoFK')
                  ->constrained('medicamentos', 'id_medicamento')
                  ->onUpdate('no action')
                  ->onDelete('no action');
            
            $table->integer('qtt_entrada');
            $table->string('lote', 45);
            $table->date('data_entrada');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoque');
    }
};
