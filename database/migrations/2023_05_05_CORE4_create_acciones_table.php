<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acciones', function (Blueprint $table) {
            $table->id();

            //Parametros para un relacion One to Many Polimorfica con Accion y Oportunidad de Mejora
            $table->unsignedBigInteger('accionable_id');
            $table->string('accionable_type');


            $table->foreignId('responsable_id')->constrained('responsables');

			$table->text('accion');
			$table->date('fechacumplimiento');
            $table->text('cumplimiento')->nullable();
			$table->date('fechacierre')->nullable();
			$table->text('recurso')->nullable();
			$table->string('estado');

            $table->foreignId('tipo_id')->constrained('tipos')->nullable();

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
        Schema::dropIfExists('accionesnc');
    }
};