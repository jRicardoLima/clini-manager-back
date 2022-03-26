<?php
namespace App\Repository;

use App\Mediators\RepositoryMediators\RepositoryMediator;
use App\Models\Employee;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class EmployeeRepository implements IRepository
{
    private $model;
    private $repoAddress;

    public function __construct(Employee $employee,AddressRepository $repoAddress)
    {
        $this->model = $employee;
        $this->repoAddress = $repoAddress;
    }

    public function save(Model $obj,bool $retModel = false): bool | Employee
    {
        $this->model->uuid = Str::uuid();
        $this->model->name = $obj->name;
        $this->model->identification = $obj->identification;
        $this->model->salary = $obj->salary;
        $this->model->professional_register = $obj->professional_register;
        $this->model->type_health_professional = $obj->type_health_professional;
        $this->model->subsidiary_id = 1;
        $this->model->occupation_id = $obj->occupation_id;

        $this->model->address_id = $this->repoAddress->save($obj->address,true)->id;

        if($this->model->save() !== true && is_numeric($this->model->address_id)){
            throw new Exception('Erro ao salvar Funcionário');
        }

        if($retModel){
           return $this->model;
        }
        return $this->model->save();
    }

    public function update(Model $obj,int|string $id): bool
    {
        $employee = null;

        if(Str::isUuid($id)){
            $employee = $this->model->where('employee.uuid',$id)->first();
        } else {
            $employee = $this->model->find($id);
        }

        $employee->name = $obj->name;
        $employee->identification = $obj->identification;
        $employee->salary = $obj->salary;
        $employee->professional_register = $obj->professional_register;
        $employee->type_health_professional = $obj->type_health_professional;
        $employee->occupation_id = $obj->occupation_id;

        $employee->addressRelation->city = $obj->address->city;
        $employee->addressRelation->zipcode = $obj->address->zipcode;
        $employee->addressRelation->street =  $obj->address->street;
        $employee->addressRelation->neighborhood = $obj->address->neighborhood;
        $employee->addressRelation->number = $obj->address->number;
        $employee->addressRelation->federative_unit = $obj->address->federative_unit;
        $employee->addressRelation->telphone_one = $obj->address->telphone_one;
        $employee->addressRelation->telphone_two = $obj->address->telphone_two;
        
        if($employee->addressRelation->save() && $employee->save()){
            return true;
        }
        return false;
    }

    public function delete(int|string $id,bool $destroy = false): bool
    {
        $employee = null;

        if(Str::isUuid($id)){
            $employee = $this->model->where('employee.uuid',$id)->first();
        } else {
            $employee = $this->model->find($id);
        }

        if($destroy){  
          return $employee->forceDelete();
        }
       
        return $employee->delete();
    }

    public function findId(int|string $id,Collection $join = null,bool $retJson = true): string|Employee
    {
        $employee = $this->model;

        if($join !== null){
            $employee = $employee->with($join->toArray());
        }
        if(Str::isUuid($id)){
            if($retJson){
                $employee = $employee->where('employee.uuid',$id)->first()->toJson();
            } else {
                $employee = $employee->where('employee.uuid')->first();
            }
        }
        if($retJson){
            $employee = $employee->find($id)->toJson();
        } else {
            $employee = $employee->find($id);
        }
        return $employee;
    }

    public function findAll(int $limit = 0,Collection $join = null,bool $retJson = true): string|EloquentCollection
    {
        $employee = $this->model;

        if($join !== null){
            $employee = $employee->with($join->toArray());    
        }

        if($limit > 0){
            if($retJson){
                $employee = $employee->limit($limit)->get()->toJson();
            } else {
                $employee = $employee->limit($limit)->get();
            }
    
        }
        if($retJson){
            $employee = $employee->get()->toJson();
        } else {
            $employee = $employee->get();
        }
        return $employee;
    }

    public function customSelect(Collection $options,Collection $columns = null,
    Collection $join = null,bool $first = false,array $order = [],
    int $limit = 0,bool $retJson = true): mixed
    {
        $employeeQuery = $this->model;

        if($columns != null){
            $employeeQuery = $employeeQuery->addSelect($columns->toArray());
        }

        if($join !== null){
            $employeeQuery = $employeeQuery->with($join->toArray());
        }

        if($options->has('occupation_relation')){
            $employeeQuery = $employeeQuery->join('occupation',
                                                  'employee.occupation_id',
                                                  "=",
                                                  'occupation.id');
        }

        if($options->has('address_relation')){
            $employeeQuery = $employeeQuery->join('address',
                                                  'employee.address_id',
                                                  "=",
                                                  'address.id');
        }

        if($options->has('id')){
            $employeeQuery = $employeeQuery->where('employee.id',$options->get('id'));
        }

        if($options->has('uuid')){
            $employeeQuery = $employeeQuery->where('employee.uuid',$options->get('uuid'));
        }

        if($options->has('name')){
            $employeeQuery = $employeeQuery->where('employee.name','LIKE',
                                                   "%".$options->get('name')."%");
        }

        if($options->has('identification')){
            $employeeQuery = $employeeQuery->where('employee.identification',$options->get('identification'));
        }

        if($options->has('salary')){
            $employeeQuery = $employeeQuery->where('employee.salary',$options->get('salary'));
        }

        if($options->has('salary_min') && $options->has('salary_max')){
            $employeeQuery = $employeeQuery->where('employee.salary','>=',
                                                   $options->get('salary_min'))
                                           ->where('employee.salary','<=',
                                                   $options->get('salary_max'));
        }

        if($options->has('profissional_register')){
            $employeeQuery = $employeeQuery->where('employee.professional_register',
                                                $options->get('professional_register'));
        }

        if($options->has('type_health_professional')){
            $employeeQuery = $employeeQuery->where('employee.type_health_professional',
                                                  $options->get('type_health_professional'));
        }

        if($options->has('subsidiary_id')){
            $employeeQuery = $employeeQuery->where('employee.subsidiary_id',
                                                  $options->get('subsidiary_id'));
        }

        if($options->has('occupation_id')){
            $employeeQuery = $employeeQuery->where('employee.occupation_id',
                                                  $options->get('occupation_id'));
        }

        if($options->has('address_id')){
            $employeeQuery = $employeeQuery->where('employee.address_id',
                                                  $options->get('address_id'));
        }

        if($order !== []){
            if(count($order) > 1){
                
                foreach($order as $key => $value){
                    $employeeQuery = $employeeQuery->orderBy($value);
                }
            } else {
                $employeeQuery = $employeeQuery->orderBy($order[0]);
            }
        }

        if($limit > 0){
            if($first){
                if($retJson){
                    return $employeeQuery->first()->toJson();
                }
                return $employeeQuery->first();
            }
            if($retJson){
                return $employeeQuery->limit($limit)->get()->toJson();
            }
            return $employeeQuery->limit($limit)->get();
        }

        if($first){
            if($retJson){
                return $employeeQuery->first()->toJson();
            }
            return $employeeQuery->first();
        }
        if($retJson){
            return $employeeQuery->get()->toJson();
        }
        return $employeeQuery->get();
    }

    public function getRawModel(): Employee
    {
        return $this->model;
    }

}

