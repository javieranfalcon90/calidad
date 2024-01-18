<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use DB;

class NomencladoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach(range(1,10) as $i){
            
            DB::table('fuentes')->insert([
                'nombre' => $faker->unique()->word(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('requisitos')->insert([
                'nombre' => $faker->unique()->word(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('clasificaciones')->insert([
                'nombre' => $faker->unique()->word(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('procesos')->insert([
                'nombre' => $faker->unique()->word(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('tipos')->insert([
                'nombre' => $faker->unique()->word(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('responsables')->insert([
                'nombre' => $faker->unique()->word(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('efectividades')->insert([
                'nombre' => $faker->unique()->word(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('niveles')->insert([
                'nombre' => $faker->unique()->word(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('noconformidades')->insert([
                'codigo' => $faker->unique()->randomDigit(),
                'descripcion' => $faker->text(100),
                'fechanotificacion' => Carbon::now(),
                'estado' => 'Nuevo',
                'fuente_id' => DB::table('fuentes')->inRandomOrder()->limit(1)->first()->id,
                'clasificacion_id' => DB::table('clasificaciones')->inRandomOrder()->limit(1)->first()->id,
                'proceso_id' => DB::table('procesos')->inRandomOrder()->limit(1)->first()->id,
                'requisito_id' => DB::table('requisitos')->inRandomOrder()->limit(1)->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);


            DB::table('riesgos')->insert([
                'codigo' => $faker->unique()->randomDigit(),
                'descripcion' => $faker->text(100),
                'fechanotificacion' => Carbon::now(),
                'estado' => 'Nuevo',
                'proceso_id' => DB::table('procesos')->inRandomOrder()->limit(1)->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('oportunidades')->insert([
                'codigo' => $faker->unique()->randomDigit(),
                'descripcion' => $faker->text(100),
                'fechanotificacion' => Carbon::now(),
                'estado' => 'Nuevo',
                'proceso_id' => DB::table('procesos')->inRandomOrder()->limit(1)->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);









        }

    }
}
