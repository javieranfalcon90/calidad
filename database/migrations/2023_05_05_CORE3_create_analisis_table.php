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
        Schema::create('analisis', function (Blueprint $table) {
            $table->id();

            //Parametros para un relacion One to One Polimorfica con Riesgo y No Conformidad
            $table->unsignedBigInteger('analisisable_id');
            $table->string('analisisable_type');

            $table->unique(['analisisable_id', 'analisisable_type']);

            $table->text('causa');
            $table->date('fecha');
            $table->text('participantes');

            $table->string('manifestacionesnegativas')->nullable();
            $table->foreignId('nivel_id')->nullable()->constrained('niveles');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisisnc');
    }
};
