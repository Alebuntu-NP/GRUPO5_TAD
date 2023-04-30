<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Categoria::factory()->create([
            'nombre' => 'Guay',
        ]);
        Categoria::factory()->create([
            'nombre' => 'Maravilloso',
        ]);
        Categoria::factory()->create([
            'nombre' => 'Alegre',
        ]);
        Categoria::factory()->create([
            'nombre' => 'Ultimo modelo',
        ]);
        Categoria::factory()->create([
            'nombre' => 'Guay',

        ]);
    }
}
