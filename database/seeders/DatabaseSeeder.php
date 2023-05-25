<?php

namespace Database\Seeders;

use App\Models\Clase;
use App\Models\Horario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Horario::factory()->count(100)->create();
        // \App\Models\User::factory(10)->create();
    }
}
