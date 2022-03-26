<?php

namespace App\Providers;

use App\Models\User;
use App\Repository\UserRepository;
use App\Services\AuthenticationService\AuthService;
use App\Services\AuthenticationService\IAuthService;
use App\Services\CommunicationApiService\CommService;
use App\Services\CommunicationApiService\ICommService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when([AuthService::class])
                  ->needs(IAuthService::class)
                  ->give(function($app){
                      
                    return new AuthService(new UserRepository(new User()));
                  });
        $this->app->when([CommService::class])
                  ->needs(ICommService::class)
                  ->give(function($app){
                      return new CommService();
                  });          
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
