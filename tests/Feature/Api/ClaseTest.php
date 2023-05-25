<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Clase;
use App\Models\Horario;

class ClaseControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function testIndex()
    {
        $clase = Clase::factory()->create();

        $response = $this->get('/api/clases');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message',
                     'result' => [
                         'current_page',
                         'data' => [
                             '*' => [
                                 'id',
                                 'nombre',
                                 'descripcion'
                             ]
                         ],
                         'first_page_url',
                         'from',
                         'last_page',
                         'last_page_url',
                         'links',
                         'next_page_url',
                         'path',
                         'per_page',
                         'prev_page_url',
                         'to',
                         'total'
                     ]
                 ]);
    }

    /**
     * @test
     */
    public function testStore()
    {
        $claseData = [
            'nombre' => 'clase de prueba 2',
            'descripcion' => 'descripcion'
        ];

        $response = $this->post('/api/clases', $claseData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message',
                     'result' => [
                         'nombre',
                         'descripcion',
                         'id'
                     ]
                 ]);
    }

    /**
     * @test
     */
    public function testShow()
    {
        $clase = Clase::factory()->create();

        $response = $this->get('/api/clases/' . $clase->id);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message',
                     'result' => [
                         'id',
                         'nombre',
                         'descripcion'
                     ]
                 ]);
    }

    /**
     * @test
     */
    public function testUpdate()
    {
        $clase = Clase::factory()->create();

        $claseData = [
            'nombre' => 'clase de prueba mod',
            'descripcion' => 'descripcion'
        ];

        $response = $this->put('/api/clases/' . $clase->id, $claseData);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message',
                     'result' => [
                         'id',
                         'nombre',
                         'descripcion'
                     ]
                 ]);
    }

    /**
     * @test
     */
    public function testDestroy()
    {
        $clase = Clase::factory()->create();

        $response = $this->delete('/api/clases/' . $clase->id);

        $response->assertStatus(204);
    }
}
