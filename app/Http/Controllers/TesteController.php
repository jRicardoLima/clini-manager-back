<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TesteController extends Controller
{
    private $authService;

    public function __construct(AuthService $auth)
    {
        $this->authService = $auth;
    }

    public function testeInject(Request $request)
    {
        Log::channel('systemLog')->critical('Erro warning',['id' => 35]);
        dd($this->communication);
    }

    public function login(Request $request)
    {
        //var_dump($request->name);
        
        try{
            return $this->authService->login($request);
            // $token = $this->authService->login($request);
            // var_dump($token);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function info(Request $request){
         return auth()->user();
        //return response()->json([$request->user()],200);
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }
}
