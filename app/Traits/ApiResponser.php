<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

trait ApiResponser
{
    /**
     * successResponse
     *
     * @param string $data
     * @param integer $code
     * @param String $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function successResponse($data, $code, $message = null): JsonResponse
    {
        return response()->json(
            [
                'status'   => $this->getStatusHttp($code),
                'code'     => $code,
                'message' => $message,
                'result'   => $data,
            ],
            $code
        );
    }

    /**
     * errorResponse
     *
     * @param string $message
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code, $result=null): JsonResponse
    {
        return response()->json(
            [
                'status'   => $this->getStatusHttp($code),
                'code'     => $code,
                'messages' => $message,
                'result'   => $result,
            ],
            $code
        );
    }

    /**
     * showData
     *
     * @param object $collection
     * @param integer $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showData($collection, $code = 200, $message = null): JsonResponse
    {
        return $this->successResponse($collection, $code, $message);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 1440, // minutes
            'user' => $this->UserAuth(),
        ], Response::HTTP_OK,'Wellcome User!');
    }


    /**
     * UserAuth
     *
     * @return void
     */
    protected function UserAuth()
    {
        $auth = Auth::user();
        $user = User::find($auth->id);
        return [
            'user'       => $auth
        ];
    }


    protected function getStatusHttp($status)
    {
        switch ($status) {
            // CODES 200
            case 200:
                $status = "OK";
                break;
            case 201:
                $status = "Created";
                break;
            // CODES 300
            // CODES 400
            case 400:
                $status = "Bad Request";
                break;
            case 401:
                $status = "Unauthorized";
                break;
            case 403:
                $status = "Forbidden";
                break;
            case 404:
                $status = "Not Found";
                break;
            case 422:
                $status = "Unprocessable";
                break;
            // CODES 500
            case 500:
                $status = "Internal Server Error";
                break;
        }

        return $status;
    }
}
