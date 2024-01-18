<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateOportunidadTable extends Migration
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
			$table->text('descripcion');
			$table->string('estado');
            $table->string('aprovechamiento');
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
}
