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
        Schema::create('itens_retirados', function (Blueprint $table) {
            $table->bigIncrements('id_item'); // Chave primária 'id_itens'
            
            // Chaves Estrangeiras
            $table->foreignId('id_retiradaFK')
                  ->constrained('retiradas', 'id_retirada')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreignId('id_medicamentoFK')
                  ->constrained('medicamentos', 'id_medicamento')
                  ->onUpdate('no action')
                  ->onDelete('no action');
            
            $table->integer('qtt_saida')->nullable();
            $table->string('lote', 45);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_retirados');
    }
};
