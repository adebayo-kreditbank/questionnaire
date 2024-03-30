<?php

namespace App\Trait;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;


trait ResponseTrait
{

    /**
     * resolve and return success response
     * @param int $statusCode, 
     * @param string $message
     * @param array $data
     * @param bool $pagination
     * @return Response
     * @return JsonResponse
     */
    public function onSuccess(int $statusCode, string $message, array $data = [], bool $pagination = false): Response|JsonResponse
    {
        if ($pagination) {
            $data = (object) $data;
            $data = $data->response()->getData(true);
        }

        return response()->json([
            "status" => $statusCode,
            "message" => ucfirst($message),
            "data" => $data,
        ], $statusCode);
    }

    /**
     * resolve and return success response
     * @param int $statusCode, 
     * @param string $message
     * @param array $data
     * @return Response
     * @return JsonResponse
     */
    public function onError($statusCode, $message, $data = []): Response|JsonResponse
    {
        return response()->json([
            "status" => $statusCode,
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }
}
