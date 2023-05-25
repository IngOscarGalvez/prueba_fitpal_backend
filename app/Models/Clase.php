<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *     schema="Clase",
 *     title="Clase",
 *     description="Clase model",
 *     @OA\Property(
 *         property="id",
 *         description="ID of the clase",
 *         type="integer",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="nombre",
 *         description="Nombre of the clase",
 *         type="string",
 *         example="Yoga Class"
 *     ),
 *     @OA\Property(
 *         property="descripcion",
 *         description="Descripción of the clase",
 *         type="string",
 *         example="A relaxing yoga class for all levels"
 *     )
 * )
 */
class Clase extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['nombre','descripcion'];
    protected $hidden = ['created_at', 'updated_at'];
}
