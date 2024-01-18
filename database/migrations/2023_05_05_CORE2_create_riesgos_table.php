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
        Schema::create('riesgos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proceso_id')->constrained('procesos');

            $table->string('codigo')->unique();
            $table->text('descripcion');
            $table->date('fechanotificacion');
            $table->date('fechacierre')->nullable();
            $table->string('estado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riesgos');
    }
};
