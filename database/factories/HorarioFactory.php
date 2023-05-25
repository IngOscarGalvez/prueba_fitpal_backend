<?php
namespace Database\Factories;

use App\Models\Horario;
use App\Models\Clase;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorarioFactory extends Factory
{
    protected $model = Horario::class;

    public function definition()
    {
        return [
            'clase_id' => Clase::factory()->create()->id,
            'fecha' => $this->faker->dateTimeBetween('2023-01-01', '2023-12-31')->format('Y-m-d'),
            'hora_inicio' => $this->faker->time(),
            'hora_final' => $this->faker->time(),
        ];
    }
}
