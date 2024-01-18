<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateNoconformidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noconformidades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fuente_id')->constrained('fuentes');
            $table->foreignId('clasificacion_id')->constrained('clasificaciones');
            $table->foreignId('proceso_id')->constrained('procesos');
            $table->foreignId('requisito_id')->constrained('requisitos');
            
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noconformidades');
    }
}
