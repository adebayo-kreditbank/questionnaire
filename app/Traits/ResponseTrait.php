<?php

namespace App\Traits;

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
     * @return Response|JsonResponse
     */
    public function onSuccess(int $statusCode, string $message = null, array|object $data = [], bool $pagination = false): Response|JsonResponse
    {
        if ($pagination) {
            $data = (object) $data;
            $data = $data->response()->getData(true);
        }

        return response()->json([
            "status" => $statusCode,
            "message" => $message ??= $this->getMessage($statusCode),
            "data" => $data,
        ], $statusCode);
    }

    /**
     * resolve and return success response
     * @param int $statusCode, 
     * @param string $message
     * @param array $data
     * @return Response|JsonResponse
     */
    public function onError($statusCode, $message, $data = []): Response|JsonResponse
    {
        return response()->json([
            "status" => $statusCode,
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }

    /**
     * Get HTTP response message
     * @param int $statusCode
     * @param string $resource
     * @return string
     */
    public function getMessage(int $statusCode, string $resource = ''): string
    {
        $message = match($statusCode) {
            Response::HTTP_OK => "{$resource} request successfully completed",
            default => "{$resource} request completed"
        };

        return ucfirst(trim($message));
    }
}
