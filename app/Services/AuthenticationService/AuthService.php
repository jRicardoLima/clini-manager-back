<?php
namespace App\Services\AuthenticationService;

use App\Repository\UserRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AuthService implements IAuthService
{
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;    
    }
    
    public function login(object $request): mixed
    {
        if(!Auth::attempt(['name' => $request->name,'password' => $request->password])){
            return false;
        }
        return $this->generateToken($request);
    }

    public function logout(object $request): mixed
    {
       
       return $request->user()->tokens()->delete();
    }

    private function generateToken(object $request,Collection $abilities = null): mixed
    {
        if(count($request->user()->tokens) >= 1){
            $request->user()->tokens()->delete();
        }
        $user = $this->user->getRawModel()->where('name',$request->name)->firstOrFail();

        if($abilities !== null){
            return $user->createToken($request->name,$abilities->toArray())->plainTextToken;
        }
        return $user->createToken($request->name)->plainTextToken;
    }

}