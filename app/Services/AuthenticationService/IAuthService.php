<?php
namespace App\Services\AuthenticationService;

interface IAuthService
{
    public function login(object $request): mixed;
    public function logout(object $request): mixed;
}