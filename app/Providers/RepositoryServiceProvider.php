<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Employee;
use App\Models\Menu;
use App\Models\Occupation;
use App\Models\Organization;
use App\Models\User;
use App\Repository\AddressRepository;
use App\Repository\EmployeeRepository;
use App\Repository\IRepository;
use App\Repository\MenuRepository;
use App\Repository\OccupationRepository;
use App\Repository\OrganizationRepository;
use App\Repository\UserRepository;
use App\Services\RepositoryService\RepositoryFactory;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(IRepository::class,function($app,$class){
        //     $factory = new IRepository();
        //     $model = new $class['model'];
        //     return (new RepositoryFactory($factory,$model))->factory();
        // });

        $this->app->when(AddressRepository::class)
                  ->needs(IRepository::class)
                  ->give(function($app){
                    return new AddressRepository();
                  });
        
        $this->app->when(EmployeeRepository::class)
                  ->needs(IRepository::class)
                  ->give(function($app){
                     return new EmployeeRepository();
                  });

        $this->app->when(MenuRepository::class)
                  ->needs(IRepository::class)
                  ->give(function($app){
                     return new MenuRepository();
                  });

        $this->app->when(OccupationRepository::class)
                  ->needs(IRepository::class)
                  ->give(function($app){
                      return new OccupationRepository();
                  });

        $this->app->when(OrganizationRepository::class)
                  ->needs(IRepository::class)
                  ->give(function($app){
                      return new OrganizationRepository();
                  });

        $this->app->when(UserRepository::class)
                  ->needs(IRepository::class)
                  ->give(function($app){
                    return new UserRepository();
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
