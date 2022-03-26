<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Employee;
use App\Repository\EmployeeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EmployeeRepositoryTest extends TestCase
{   
    private $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = App::make(EmployeeRepository::class);
    }


    public function testSaveEmployee()
    {
        $employee = new Employee();

        $employee->name = "Jessica Testando";
        $employee->identification = "036.265.951.88";
        $employee->salary = 3500.25;
        $employee->type_health_professional = true;
        $employee->subsidiary_id = 1;
        $employee->occupation_id = 1;

        $employee->address = new Address();
        $employee->address->city = "Cuiaba";
        $employee->address->zipcode = "78200-500";
        $employee->address->street = "Avenida Dom Bosco";
        $employee->address->neighborhood = "Vale verde";
        $employee->address->number = "200";
        $employee->address->federative_unit = "MT";
        $employee->address->telphone_one = "65 99929-1355";
        $employee->address->subsidiary_id = 1;
        
       $this->assertEquals(true,$this->repo->save($employee));
    }
    
    public function testUpdateEmployee()
    {
        $idEmp = DB::table('employee')->max('employee.id');
        $idAddr = DB::table('address')->max('address.id');

        $employee = new Employee();

        $employee->name = "Joao Teste";
        $employee->identification = "034.895.789.36";
        $employee->salary = 2500.25;
        $employee->type_health_professional = true;
        $employee->subsidiary_id = 1;
        $employee->occupation_id = 1;

        $employee->address = new Address();
        $employee->address->id = $idAddr;
        $employee->address->city = "Cáceres";
        $employee->address->zipcode = "78200-000";
        $employee->address->street = "Rua Coronel Cordeiro Henrique Do Oeste";
        $employee->address->neighborhood = "Santa Izabel";
        $employee->address->number = "77";
        $employee->address->federative_unit = "MT";
        $employee->address->telphone_one = "65 99929-1300";
        $employee->address->telphone_two = "65 3223-0697";
        $employee->address->subsidiary_id = 1;

        $this->assertEquals(true,$this->repo->update($employee,$idEmp));
    }
    
    public function testFindIdModel()
    {
        $id = DB::table('employee')->max('employee.id');

        $ret = $this->repo->findId($id,false);

        $this->assertInstanceOf(Employee::class,$ret);
    }

    public function testFindIdString()
    {
        $id = DB::table('employee')->max('employee.id');

        $ret = $this->repo->findId($id);
        $json = '{"id":5,"uuid":"630715af-92aa-4bf3-b263-68fa01c40ce3","name":"Joao Teste",
                 "identification":"034.895.789.36","salary":2500.25,
                 "professional_register":null,"type_health_professional":1,
                 "subsidiary_id":1,"created_at":"2022-03-20T07:19:43.000000Z",
                 "updated_at":"2022-03-20T07:40:14.000000Z",
                 "deleted_at":null,"occupation_id":1,
                 "address_id":5}';

        $this->assertJson($json,$ret);
    }

    public function testFindAllCollectionEloquent()
    {
        $ret = $this->repo->findAll(retJson:false);

        $this->assertInstanceOf(Collection::class,$ret);
    }

    public function testFindAllJson()
    {
        $ret = $this->repo->findAll();

        $json = '[{"id":1,"uuid":"db6805b1-4a0d-4467-9b1f-084ae19073f9","identification":"033.894.541-52","name": "João Ricardo Lima","salary":1800.25,"professional_register":null,"type_health_professional":0,"subsidiary_id":1,"created_at":"2022-03-15T19:28:11.000000Z","updated_at":"2022-03-20T05:33:44.000000Z","deleted_at":null,"occupation_id":1,"address_id":1}]';

       $this->assertJson($json,$ret);                 
    }

    public function testFindAllLimit()
    {
        $ret = $this->repo->findAll(2,false);


        $this->assertCount(2,$ret->toArray());
    }

    public function testDeleteEmployee()
    {
        $id = DB::table('employee')->max('employee.id');

        $this->assertEquals(true,$this->repo->delete($id));
    }
}
