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
        Schema::create('retiradas', function (Blueprint $table) {
            $table->bigIncrements('id_retirada');
            // Chaves Estrangeiras
            $table->foreignId('id_funcionarioFK')
                  ->constrained('funcionarios', 'id_funcionario')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreignId('id_postoFK')
                  ->constrained('postos_saude', 'id_posto')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->string('cod_saida', 8);
            $table->string('status', 24)->nullable();
            $table->date('data_saida');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retiradas');
    }
};
