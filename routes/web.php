<?php

use App\Http\Controllers\TesteController;
use App\Mediators\RepositoryMediators\RepositoryMediator;
use App\Models\Address;
use App\Models\Employee;
use App\Models\Menu;
use App\Models\Occupation;
use App\Models\Organization;
use App\Models\Subsidiary;
use App\Models\User;
use App\Repository\AddressRepository;
use App\Repository\EmployeeRepository;
use App\Repository\MenuRepository;
use App\Repository\OccupationRepository;
use App\Repository\OrganizationRepository;
use App\Repository\SubsidiaryRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/testando',[TesteController::class,'testeInject']);
Route::post('/logar',[TesteController::class,'login']);

Route::get('/teste',function(){
     $employeeRepo = App::make(EmployeeRepository::class);
     $employee = $employeeRepo->findAll();

     var_dump($employee);
    //  $employee = new stdClass();

    // $employee = new Employee();

    // $employee->name = "Jessica Testando";
    // $employee->identification = "036.265.951.88";
    // $employee->salary = 3500.25;
    // $employee->type_health_professional = true;
    // $employee->subsidiary_id = 1;
    // $employee->occupation_id = 1;

    // $employee->address = new Address();
    // $employee->address->city = "Cuiaba";
    // $employee->address->zipcode = "78200-500";
    // $employee->address->street = "Avenida Dom Bosco";
    // $employee->address->neighborhood = "Vale verde";
    // $employee->address->number = "200";
    // $employee->address->federative_unit = "MT";
    // $employee->address->telphone_one = "65 99929-1355";
    // $employee->address->subsidiary_id = 1;

    // var_dump($employeeRepo->save($employee));

    //  dd($employeeRepo->update($employee,2));
     //$organizationRepo = App::make(OrganizationRepository::class,['model' => Organization::class]);
     //$subsidiaryRepo = App::make(SubsidiaryRepository::class,['model' => Subsidiary::class]);
     //$occupationRepo = App::make(OccupationRepository::class,['model' => Occupation::class]);
     //$userRepo = App::make(UserRepository::class,['Model' => User::class]);
    // $obj = new Menu();
    // $obj->id = 1;
    // $obj->label = "Especialidades";
    // //$obj->icon = "pi pi-fw pi-heart";
    // $obj->command = "{name:'specialtie'}";
    // $obj->module = "cadastros";
    // //$option = collect(['uuid' => "04be97a2-537b-4263-ba2a-e74b04b9f881"]);
    // //$coluns = collect(["menu.label","menu.command"]);
    // dd($testeProvider->update($obj,1));

    // $organization = new Organization();

    // $organization->name = "Clinica de Testes LTDA";
    // $organization->identification = "06.771.010/0001-07";
    // $organization->cnes = "0667301257-2";
    // $organization->license = "abc06645677xyz";
    // $organization->type_plan = "premium";
    // $organization->number_user = "35";
    // $organization->number_clinics = "5";
    // $organization->due_date_license = "2022-12-14";

    //dd($organizationRepo->save($organization));
    
    // $subsidiary = new Subsidiary();

    // $subsidiary->name = "Clinica de Teste";
    // $subsidiary->cnes = "4125412511-5";
    // $subsidiary->identification = "033874574-56";
    // $subsidiary->organization_id = 1;

     //dd($subsidiaryRepo->save($subsidiary,true));  
    // $occupation = new Occupation();

    // $occupation->name = "Administrativo";
    // $occupation->subsidiary_id = 1;

    //dd($occupationRepo->save($occupation));

    // $obj = new Employee();

    // $obj->name = "João Ricardo Lima";
    // $obj->identification = "033.894.541-52";
    // $obj->salary = 1800.25;
    // $obj->type_health_professional = false;
    // $obj->subsidiary_id = 1;
    // $obj->occupation_id = 1;

    // $obj->address = new Address();

    // $obj->address->city = "Primavera do Leste";
    // $obj->address->zipcode = "78850-000";
    // $obj->address->street = "Flor de Liz";
    // $obj->address->neighborhood = "Pioneiro";
    // $obj->address->number = "71";
    // $obj->address->federative_unit = "MT";
    // $obj->address->telphone_one = "66996239237";
    // $obj->address->email = "j.ricardo_lima@outlook.com";
    // $obj->address->subsidiary_id = 1;

    //dd($employeeRepo->save($obj));

    // $user = new User();

    // $user->name = "JRicardoLima";
    // $user->password = bcrypt('123456');
    // $user->employee_id = 1;
    // $user->subsidiary_id = 1;

    //dd($userRepo->save($user));
});
