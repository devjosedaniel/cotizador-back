<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('productos')->insert(
            [
                [
                    'nombre' => 'Producto 1',
                    'categoria_id' => 1
                ],
                [
                    'nombre' => 'Producto 2',
                    'categoria_id' => 1
                ]
            ]
        );
    }
}
