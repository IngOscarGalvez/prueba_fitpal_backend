<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Horario;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Horario\CreateHorarioRequest;
use App\Http\Requests\Api\Horario\UpdateHorarioRequest;
use App\Models\Clase;

class HorarioController extends Controller
{
    use ApiResponser;
    /**
     * @OA\Get(
     *     path="/api/horarios",
     *     tags={"Horarios"},
     *     summary="Obtener todos los horarios",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Número de elementos por página",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="historico",
     *         in="query",
     *         description="Incluir horarios históricos",
     *         @OA\Schema(type="integer", default=0, enum={0, 1})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="App\Models\Horario")),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer"),
     *         )
     *     ),
     * )
     */
    public function index(Request $request) : JsonResponse
    {
        $fechaActual = Carbon::now()->toDateString();
        $fechaMaxima = Carbon::now()->addDays(8)->toDateString();
        // query principal
        $query = Horario::query()
                            ->with('clase')
                            ->orderBy('horarios.fecha', 'desc');
        // convierto el query params en boolean
        $historico = boolval($request->query('historico'));
        // si no tiene historico se realiza la query de las fechas de diferencia de 8 dias
        if(!$historico){
            $query->whereBetween('horarios.fecha', [$fechaActual, $fechaMaxima]);
        }
        // filtro los que no tiene clases nulas si las borra.
        $query->whereExists(function ($subQuery) {
            $subQuery->select(DB::raw(1))
                ->from('clases')
                ->whereColumn('horarios.clase_id', 'clases.id')
                ->whereNull('clases.deleted_at');
        })
        ->orWhereNull('clase_id');


        return $this->showData(
            $query->paginate($request->query('per_page', 10)),
            Response::HTTP_OK,
            'Listar Horario'
        );
    }

    /**
     * @OA\Post(
     *     path="/api/horarios",
     *     tags={"Horarios"},
     *     summary="Crear un nuevo horario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="App\Models\Horario")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="App\Models\Horario")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     * )
     */
    public function store(CreateHorarioRequest $request) : JsonResponse
    {
        $horario = Horario::create($request->all());
        return $this->successResponse($horario,Response::HTTP_CREATED, 'Horario Creado !');
    }

    /**
     * @OA\Get(
     *     path="/api/horarios/{horario}",
     *     tags={"Horarios"},
     *     summary="Obtener los detalles de un horario",
     *     @OA\Parameter(
     *         name="horario",
     *         in="path",
     *         required=true,
     *         description="ID del horario",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="App\Models\Horario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Horario not found.")
     *         )
     *     ),
     * )
     */
    public function show(Horario $horario) : JsonResponse
    {
        return $this->successResponse($horario,Response::HTTP_OK, 'Ver Horario');
    }

    /**
     * @OA\Put(
     *     path="/api/horarios/{horario}",
     *     tags={"Horarios"},
     *     summary="Actualizar un horario existente",
     *     @OA\Parameter(
     *         name="horario",
     *         in="path",
     *         required=true,
     *         description="ID del horario",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="App\Models\Horario")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="App\Models\Horario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Horario not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     * )
     */
    public function update(UpdateHorarioRequest $request, Horario $horario) : JsonResponse
    {
        $horario->update($request->all());
        return $this->successResponse($horario,Response::HTTP_OK, 'Horario Actualizado!');
    }

    /**
     * @OA\Delete(
     *     path="/api/horarios/{horario}",
     *     tags={"Horarios"},
     *     summary="Eliminar un horario existente",
     *     @OA\Parameter(
     *         name="horario",
     *         in="path",
     *         required=true,
     *         description="ID del horario",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Content"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Horario not found.")
     *         )
     *     ),
     * )
     */
    public function destroy(Horario $horario) : JsonResponse
    {
        $horario->delete();
        return $this->successResponse($horario,Response::HTTP_NO_CONTENT, '');
    }

    public function listarClasesSelect()
    {
        $clases = Clase::query()->select('id','nombre')->get();
        return $this->successResponse($clases,Response::HTTP_OK, 'Listar Clases Select');
    }
}
