<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categorias')->insert(
            [
                [
                    'nombre' => 'Categoria 1',
                ],
                [
                    'nombre' => 'Categoria 2',
                ]
            ]
        );
    }
}
