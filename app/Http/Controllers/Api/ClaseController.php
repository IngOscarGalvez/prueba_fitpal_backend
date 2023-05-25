<?php

namespace App\Http\Controllers\Api;

use App\Models\Clase;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Clase\CreateClaseRequest;
use App\Http\Requests\Api\Clase\UpdateClaseRequest;
use Illuminate\Http\JsonResponse;

class ClaseController extends Controller
{
    use ApiResponser;

   /**
     * @OA\Get(
     *     path="/api/clases",
     *     tags={"Clases"},
     *     summary="Obtener todas las clases",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Número de elementos por página",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Listar Clase"),
     *             @OA\Property(
     *                 property="result",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="App\Models\Clase")),
     *                 @OA\Property(property="first_page_url", type="string"),
     *                 @OA\Property(property="from", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="last_page_url", type="string"),
     *                 @OA\Property(property="links", type="object"),
     *                 @OA\Property(property="next_page_url", type="string", nullable=true),
     *                 @OA\Property(property="path", type="string"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="prev_page_url", type="string", nullable=true),
     *                 @OA\Property(property="to", type="integer"),
     *                 @OA\Property(property="total", type="integer"),
     *             )
     *         )
     *     ),
     * )
     */
    public function index() : JsonResponse
    {
        $clases = Clase::paginate();

        return $this->showData(
            $clases,
            Response::HTTP_OK,
            'Listar Clase'
        );

    }

    /**
     * @OA\Post(
     *     path="/api/clases",
     *     tags={"Clases"},
     *     summary="Crear una nueva clase",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="App\Models\Clase")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="App\Models\Clase")
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
    public function store(CreateClaseRequest $request) : JsonResponse
    {
        $clase = Clase::create($request->all());
        return $this->successResponse($clase,Response::HTTP_CREATED, 'Clase Creada !');
    }

    /**
     * @OA\Get(
     *     path="/api/clases/{clase}",
     *     tags={"Clases"},
     *     summary="Obtener los detalles de una clase",
     *     @OA\Parameter(
     *         name="clase",
     *         in="path",
     *         required=true,
     *         description="ID de la clase",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="App\Models\Clase")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Clase not found.")
     *         )
     *     ),
     * )
     */
    public function show(Clase $clase) : JsonResponse
    {
        return $this->successResponse($clase,Response::HTTP_OK, 'Ver Clase');
    }

    /**
     * @OA\Put(
     *     path="/api/clases/{clase}",
     *     tags={"Clases"},
     *     summary="Actualizar una clase existente",
     *     @OA\Parameter(
     *         name="clase",
     *         in="path",
     *         required=true,
     *         description="ID de la clase",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="App\Models\Clase")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="App\Models\Clase")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Clase not found.")
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
    public function update(UpdateClaseRequest $request, Clase $clase) : JsonResponse
    {
        $clase->update($request->all());
        return $this->successResponse($clase,Response::HTTP_OK, 'Clase Actualizada!');
    }

    /**
     * @OA\Delete(
     *     path="/api/clases/{clase}",
     *     tags={"Clases"},
     *     summary="Eliminar una clase",
     *     @OA\Parameter(
     *         name="clase",
     *         in="path",
     *         required=true,
     *         description="ID de la clase",
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
     *             @OA\Property(property="message", type="string", example="Clase not found.")
     *         )
     *     ),
     * )
     */
    public function destroy(Clase $clase) : JsonResponse
    {
        $clase->delete();
        return $this->successResponse($clase,Response::HTTP_NO_CONTENT, '');
    }
}
