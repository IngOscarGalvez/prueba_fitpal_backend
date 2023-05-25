<?php

namespace Tests\Unit\Models;

use App\Models\Clase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para verificar que se pueda crear una instancia de Clase.
     *
     * @return void
     */
    public function testCreateClase()
    {
        $clase = Clase::factory()->create([
            'nombre' => 'Clase de ejemplo',
            'descripcion' => 'Descripción de la clase de ejemplo',
        ]);

        $this->assertInstanceOf(Clase::class, $clase);
        $this->assertEquals('Clase de ejemplo', $clase->nombre);
        $this->assertEquals('Descripción de la clase de ejemplo', $clase->descripcion);
    }

    /**
     * Test para verificar que se puedan actualizar los campos de Clase.
     *
     * @return void
     */
    public function testUpdateClase()
    {
        $clase = Clase::factory()->create();

        $clase->update([
            'nombre' => 'Nuevo nombre',
            'descripcion' => 'Nueva descripción',
        ]);

        $this->assertEquals('Nuevo nombre', $clase->nombre);
        $this->assertEquals('Nueva descripción', $clase->descripcion);
    }

    /**
     * Test para verificar que se pueda eliminar una Clase.
     *
     * @return void
     */
    public function testDeleteClase()
    {
        $clase = Clase::factory()->create();

        $clase->delete();

        $this->assertDeleted($clase);
    }
}
