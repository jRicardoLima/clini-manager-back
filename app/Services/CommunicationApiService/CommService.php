<?php
namespace App\Services\CommunicationApiService;

class CommService implements ICommService
{
    public function success(mixed $data,string $message = null,int $statusCode = 200): mixed
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ],$statusCode);
    }

    public function error(int $statusCode,mixed $data,string $message = null): mixed
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ],$statusCode);
    }
}