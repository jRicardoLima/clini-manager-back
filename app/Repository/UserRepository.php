<?php
namespace App\Repository;

use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements IRepository
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function save(Model $obj,bool $retModel = false): bool|Model
    {
        $this->model->uuid = Str::uuid();
        $this->model->name = $obj->name;
        $this->model->email = $obj->email;
        $this->model->password= $obj->password;
        $this->model->employee_id = $obj->employee_id;
        $this->model->subsidiary_id = $obj->subsidiary_id;

        if($this->model->save() !== true){
            throw new Exception('Erro ao salvar Usuário Sistema');
        }

        if($retModel){
            return $this->model;
        }
        return true;
    }

    public function update(Model $obj,int|string $id): bool
    {
        $user = null;

        if(Str::isUuid($id)){
            $user = $this->model->where('uuid',$id)->first();
        } else {
            $user = $this->model->find($id);
        }

        $user->name = $obj->name;
        $user->email = $obj->email;
        $user->password = $obj->password;

        if($user->save() !== true){
            throw new Exception('Erro ao atualizar Usuário Sistema');
        }
        return true;
    }

    public function delete(int|string $id,bool $destroy = false): bool
    {
        $user = null;

        if(Str::isUuid($id)){
            $user = $this->model->where('uuid',$id)->first();
        } else {
            $user = $this->model->find($id);
        }

        if($destroy){
            if($user->forceDelete() !== true){
                throw new Exception('Erro ao Excluir permanentemente Usuário');
            }
            return true;
        }

        if($user->delete() !== true){
            throw new Exception('Erro ao excluir Usuário');
        }
        return true;
    }
    
    public function findId(int|string $id,Collection $join = null,bool $retJson = true): string
    {
        $user = $this->model;

        if($join !== null){
            $user = $user->with($join->toArray());
        }

        if(Str::isUuid($id)){
            if($retJson){
                $user = $user->where('users.uuid',$id)->first()->toJson();
            } else{
                $user = $user->where('users.uuid',$id)->first();
            }
        }

        if($retJson){
            $user = $user->find($id)->toJson();
        } else {
            $user = $user->find($id);
        }
        return $user;
    }
    
    public function findAll(int $limit = 0,Collection $join = null,bool $retJson = true): string
    {
        $user = $this->model;

        if($join){
            $user = $user->with($join->toArray());
        }

        if($limit > 0){
            if($retJson){
                $user = $user->limit($limit)->get()->toJson();
            } else {
                $user = $user->limit($limit)->get();
            }
        }

        if($retJson){
            $user = $user->get()->toJson();
        } else {
            $user = $user->get();
        }
        return $user;
    }
    
    public function customSelect(Collection $options,Collection $columns = null,
    Collection $join = null,bool $first = false,array $order = [],
    int $limit = 0,bool $retJson = true): mixed
    {
        $userQuery = $this->model;

        if($columns !== null){
            $userQuery = $userQuery->addSelect($columns->toArray());
        }

        if($join !== null){
            $userQuery = $userQuery->with($join->toArray());
        }

        if($options->has('id')){
            $userQuery = $userQuery->where('users.id',$options->get('id'));
        }

        if($options->has('uuid')){
            $userQuery = $userQuery->where('users.uuid',$options->get('uuid'));
        }

        if($options->has('name')){
            $userQuery = $userQuery->where('users.name',$options->get('name'));
        }

        if($options->has('email')){
            $userQuery = $userQuery->where('users.email',$options->get('email'));
        }

        if($options->has('employee_id')){
            $userQuery = $userQuery->where('users.employee_id',$options->get('employee_id'));
        }

        if($options->has('subsidiary_id')){
            $userQuery = $userQuery->where('users.subsidiary_id',$options->get('subsidiary_id'));
        }

        if($order !== []){
            if(count($order) > 1){

                foreach($order as $key => $value){
                    $userQuery = $userQuery->orderBy($value);
                }
            } else {
                $userQuery = $userQuery->orderBy($order[0]);
            }
        }

        if($limit > 0){
            if($first){
                if($retJson){
                    return $userQuery->first()->toJson();
                }
                return $userQuery->first();
            }
            if($retJson){
                return $userQuery->limit($limit)->get()->toJson();
            }
            return $userQuery->limit($limit)->get();
        }

        if($first){
            if($retJson){
                return $userQuery->first()->toJson();
            }
            return $userQuery->first();
        }
        if($retJson){
            return $userQuery->get()->toJson();
        }
        return $userQuery->get();
    }

    public function getRawModel(): User
    {
        return $this->model;
    }
}