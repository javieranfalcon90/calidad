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
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();

            $table->text('descripcion');
            $table->date('fecha');
            $table->text('conclusion');

            $table->foreignId('efectividad_id')->constrained('efectividades');

            $table->foreignId('riesgo_id')->unique()->constrained('riesgos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
