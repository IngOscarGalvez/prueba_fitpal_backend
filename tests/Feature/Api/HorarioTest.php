<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Horario;
use App\Models\Clase;

class HorarioTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        // Crear algunos horarios utilizando factories
        Horario::factory()->count(5)->create();

        // Simular la respuesta del endpoint de listado de horarios
        $response = $this->json('GET', '/api/horarios');

        // Verificar el código de estado de la respuesta
        $response->assertStatus(200);

        // Verificar la estructura de la respuesta JSON
        $response->assertJsonStructure([
            'status',
            'code',
            'message',
            'result' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'clase_id',
                        'fecha',
                        'hora_inicio',
                        'hora_final',
                        'clase' => [
                            'id',
                            'nombre',
                            'descripcion'
                        ]
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active'
                    ]
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);

    }

    public function testStore()
    {
        // Crear la clase utilizando un factory
        $clase = Clase::factory()->create();

        // Datos de prueba para crear un horario
        $data = [
            'fecha' => '2023-05-22',
            'hora_inicio' => '09:00',
            'hora_final' => '10:00',
            'clase_id' => $clase->id
        ];

        // Simular la respuesta del endpoint de creación de horarios
        $response = $this->json('POST', '/api/horarios', $data);

        // Verificar el código de estado de la respuesta
        $response->assertStatus(201);

        // Verificar la estructura de la respuesta JSON
        $response->assertJsonStructure([
            'status',
            'code',
            'message',
            'result' => [
                'fecha',
                'hora_inicio',
                'hora_final',
                'clase_id',
                'id'
            ]
        ]);

        // Eliminar el horario creado y la clase asociada para limpiar la base de datos
        Horario::where('id', $response->json('result.id'))->delete();
        Clase::where('id', $clase->id)->delete();
    }

    public function testShow()
    {
        // Crear la clase utilizando un factory
        $clase = Clase::factory()->create();

        // Crear el horario utilizando un factory
        $horario = Horario::factory()->create(['clase_id' => $clase->id]);

        // Simular la respuesta del endpoint para mostrar el horario creado
        $response = $this->json('GET', '/api/horarios/' . $horario->id);

        // Verificar el código de estado de la respuesta
        $response->assertStatus(200);

        // Verificar la estructura de la respuesta JSON
        $response->assertJsonStructure([
            'status',
            'code',
            'message',
            'result' => [
                'id',
                'clase_id',
                'fecha',
                'hora_inicio',
                'hora_final'
            ]
        ]);

        // Eliminar el horario creado y la clase asociada para limpiar la base de datos
        Horario::where('id', $horario->id)->delete();
        Clase::where('id', $clase->id)->delete();
    }

    public function testUpdate()
    {
        // Crear la clase utilizando un factory
        $clase = Clase::factory()->create();

        // Crear el horario utilizando un factory
        $horario = Horario::factory()->create(['clase_id' => $clase->id]);

        // Datos de prueba para actualizar el horario
        $data = [
            'fecha' => "2023-05-22",
            'hora_inicio' => '09:00',
            'hora_final' => '12:00',
            "clase_id" => $clase->id
        ];

        // Simular la respuesta del endpoint de actualización de horarios
        $response = $this->json('PUT', '/api/horarios/' . $horario->id, $data);

        // Verificar el código de estado de la respuesta
        $response->assertStatus(200);

        // Verificar la estructura de la respuesta JSON
        $response->assertJsonStructure([
            'status',
            'code',
            'message',
            'result' => [
                'id',
                'clase_id',
                'fecha',
                'hora_inicio',
                'hora_final'
            ]
        ]);

        // Eliminar el horario creado y la clase asociada para limpiar la base de datos
        Horario::where('id', $horario->id)->delete();
        Clase::where('id', $clase->id)->delete();
    }

    public function testDelete()
    {
        // Crear la clase utilizando un factory
        $clase = Clase::factory()->create();

        // Crear el horario utilizando un factory
        $horario = Horario::factory()->create(['clase_id' => $clase->id]);

        // Simular la respuesta del endpoint para eliminar el horario creado
        $response = $this->json('DELETE', '/api/horarios/' . $horario->id);

        // Verificar el código de estado de la respuesta
        $response->assertStatus(204);

        // Eliminar la clase asociada para limpiar la base de datos
        Clase::where('id', $clase->id)->delete();
    }
}
