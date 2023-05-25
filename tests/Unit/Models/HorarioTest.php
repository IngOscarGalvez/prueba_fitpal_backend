<?php

namespace Tests\Unit\Models;


use Tests\TestCase;
use App\Models\Horario;
use App\Models\Clase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HorarioTest extends TestCase
{
    use RefreshDatabase;

    public function testHorarioBelongsToClase()
    {
        // Crea una instancia de Clase
        $clase = Clase::factory()->create();

        // Crea una instancia de Horario y la asocia a la Clase creada
        $horario = Horario::factory()->create(['clase_id' => $clase->id]);

        // Verifica que la relación pertenece a Clase
        $this->assertInstanceOf(Clase::class, $horario->clase);
    }

    public function testHorarioIsFillable()
    {
        // Define los datos de prueba
        $data = [
            'fecha' => '2023-05-25',
            'hora_inicio' => '10:00:00',
            'hora_final' => '12:00:00',
        ];

        // Crea una instancia de Horario con los datos de prueba
        $horario = new Horario($data);

        // Verifica que los datos de prueba sean asignables
        $this->assertEquals($data, $horario->toArray());
    }

    public function testHiddenFields()
    {
        // Crea una instancia de Horario
        $horario = Horario::factory()->create();

        // Verifica que los campos ocultos estén ocultos
        $this->assertFalse(array_key_exists('created_at', $horario->toArray()));
        $this->assertFalse(array_key_exists('updated_at', $horario->toArray()));
    }

    public function testHorarioCanBeCreated()
    {
        // Crea una instancia de Horario con datos de prueba
        $horario = Horario::factory()->create([
            'fecha' => '2023-05-25',
            'hora_inicio' => '10:00:00',
            'hora_final' => '12:00:00',
        ]);

        // Verifica que se haya creado exitosamente
        $this->assertDatabaseHas('horarios', [
            'id' => $horario->id,
            'fecha' => '2023-05-25',
            'hora_inicio' => '10:00:00',
            'hora_final' => '12:00:00',
        ]);
    }

    public function testHorarioCanBeUpdated()
    {
        // Crea una instancia de Horario
        $horario = Horario::factory()->create();

        // Actualiza los datos del Horario
        $horario->update([
            'fecha' => '2023-05-26',
            'hora_inicio' => '09:00:00',
            'hora_final' => '11:00:00',
        ]);

        // Verifica que los cambios se hayan guardado en la base de datos
        $this->assertDatabaseHas('horarios', [
            'id' => $horario->id,
            'fecha' => '2023-05-26',
            'hora_inicio' => '09:00:00',
            'hora_final' => '11:00:00',
        ]);
    }

    public function testHorarioCanBeDeleted()
    {
        // Crea una instancia de Horario
        $horario = Horario::factory()->create();

        // Elimina el Horario
        $horario->delete();

        // Verifica que se haya eliminado correctamente
        $this->assertDeleted($horario);
    }
}
