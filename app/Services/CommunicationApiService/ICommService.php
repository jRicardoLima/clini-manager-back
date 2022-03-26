<?php
namespace App\Services\CommunicationApiService;

interface ICommService
{
    public function success(mixed $data,string $message = null,int $statusCode = 200): mixed;
    public function error(int $statusCode,mixed $data,string $message = null,): mixed;
}