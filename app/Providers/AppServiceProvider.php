<?php

namespace App\Providers;

use App\Mediators\IMediator;
use App\Mediators\Mediator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Mediator::class,function($app,$classe){
            return new $classe['class'];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
