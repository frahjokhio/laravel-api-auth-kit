<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Trait ApiResponse
 * @package App\Shared\Traits
 *
 * For formatting consistent JSON responses across the application.
 */
trait ApiResponse
{
    /**
     * Return a successful JSON response.
     *
     * @param mixed $data The payload to return.
     * @param string $message A success message.
     * @param int $statusCode HTTP status code.
     * @return JsonResponse
     */
    protected function success(mixed $data, string $message = 'Success', int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return an error JSON response.
     *
     * @param string $message An error message.
     * @param int $statusCode HTTP status code.
     * @param mixed|null $errors Optional validation errors or other error details.
     * @return JsonResponse
     */
    protected function error(string $message, int $statusCode = Response::HTTP_BAD_REQUEST, mixed $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a "Not Found" JSON response.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function notFound(string $message = 'Resource not found.'): JsonResponse
    {
        return $this->error($message, Response::HTTP_NOT_FOUND);
    }

    /**
     * Return a "Forbidden" JSON response.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function forbidden(string $message = 'This action is unauthorized.'): JsonResponse
    {
        return $this->error($message, Response::HTTP_FORBIDDEN);
    }
}
