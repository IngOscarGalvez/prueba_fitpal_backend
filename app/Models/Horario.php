<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *     schema="Horario",
 *     title="Horario",
 *     description="Horario model",
 *     @OA\Property(
 *         property="id",
 *         description="ID of the horario",
 *         type="integer",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="fecha",
 *         description="Fecha of the horario",
 *         type="string",
 *         example="2023-05-21"
 *     ),
 *     @OA\Property(
 *         property="hora_inicio",
 *         description="Hora de inicio del horario",
 *         type="string",
 *         example="09:00:00"
 *     ),
 *     @OA\Property(
 *         property="hora_final",
 *         description="Hora de finalización del horario",
 *         type="string",
 *         example="10:30:00"
 *     ),
 *     @OA\Property(
 *         property="clase_id",
 *         description="ID of the related clase",
 *         type="integer",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="clase",
 *         description="Related clase",
 *         ref="App\Models\Clase"
 *     )
 * )
 */
class Horario extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['fecha', 'hora_inicio', 'hora_final','clase_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}
