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
        Schema::create('oportunidades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proceso_id')->constrained('procesos');

            $table->string('codigo')->unique();
            $table->string('tipo');
			$table->text('descripcion');
			$table->string('estado');
            $table->string('aprovechamiento')->nullable();
			$table->date('fechanotificacion');
			$table->date('fechacierre')->nullable();
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
        Schema::dropIfExists('oportunidades');
    }
};
