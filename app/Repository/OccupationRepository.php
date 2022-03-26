<?php
namespace App\Repository;

use App\Models\Occupation;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class OccupationRepository implements IRepository
{
    private $model;

    public function __construct(Occupation $occupation)
    {
        $this->model = $occupation;
    }

    public function save(Model $obj,bool $retModel = false): bool|Model
    {
        $this->model->uuid = Str::uuid();
        $this->model->name = $obj->name;
        $this->model->subsidiary_id = $obj->subsidiary_id;

        if($this->model->save() !== true){
            throw new Exception('Erro ao salvar Função');
        }

        if($retModel){
           return $this->model;
        }
        return $this->model->save();
    }

    public function update(Model $obj,int|string $id): bool
    {
        $occupation = null;

        if(Str::isUuid($id)){
            $occupation = $this->model->where('uuid',$id)->first();
        } else {
            $occupation = $this->model->find($id);
        }

        return $occupation->save();

    }

    public function delete(int|string $id,bool $destroy = false): bool
    {
        $occupation = null;

        if(Str::isUuid($id)){
            $occupation = $this->model->where('uuid',$id)->first();

            if($destroy){
                return $occupation->forceDelete();
            }
            return $occupation->delete();
        }

        $occupation = $this->model->find($id);

        if($destroy){
            return $occupation->forceDelete();
        }
        return $occupation->delete();
    }

    public function findId(int|string $id,Collection $join = null,bool $retJson = true): string
    {
        $occupation = $this->model;

        if($join !== null){
            $occupation = $occupation->with($join->toArray());
        }

        if(Str::isUuid($id)){
            if($retJson){
                $occupation = $occupation->where('occupation.uuid',$id)->first()->toJson();
            } else {
                $occupation = $occupation->where('occupation.uuid',$id)->first();
            }
        }
        if($retJson){
            $occupation = $occupation->find($id)->first()->toJson();
        } else {
            $occupation = $occupation->find($id);
        }
        return $occupation;
    }

    public function findAll(int $limit = 0,Collection $join = null,bool $retJson = true): string
    {
        $occupation = $this->model;

        if($join !== null){
            $occupation = $occupation->with($join->toArray());    
        }

        if($limit > 0){
            if($retJson){
                $occupation = $occupation->limit($limit)->get()->toJson();
            } else {
                $occupation = $occupation->limit($limit)->get();
            }
        }
        if($retJson){
            $occupation = $occupation->get()->toJson();
        } else {
            $occupation = $occupation->get();
        }
        return $occupation;
    }

    public function customSelect(Collection $options,Collection $columns = null,
    Collection $join = null,bool $first = false,array $order = [],
    int $limit = 0,bool $retJson = true): mixed
    {
        $occupationQuery = $this->model;

        if($columns !== null){
            $occupationQuery = $occupationQuery->addSelect($columns->toArray());
        }

        if($join){
           $occupationQuery = $occupationQuery->with($join->toArray());
        }

        if($options->has('employee_relation')){
            $occupationQuery = $occupationQuery->join('employee','occupation.id',
                                                       '=','employee.occupation_id');
        }

        if($options->has('id')){
            $occupationQuery = $occupationQuery->where('occupation.id',$options->get('id'));
        }

        if($options->has('name')){
            $occupationQuery = $occupationQuery->where('occupation.name','LIKE',
                                                       '%'.$options->get('name').'%');
        }

        if($order !== []){
            if(count($order) > 1){
                
                foreach($order as $key => $value){
                    $occupationQuery = $occupationQuery->orderBy($value);
                }
            } else {
                $occupationQuery = $occupationQuery->orderBy($order[0]);
            }
        }

        if($limit > 0){
            if($first){
                if($retJson){
                    return $occupationQuery->first()->toJson();
                }
                return $occupationQuery->first();
            }
            if($retJson){
                return $occupationQuery->first()->toJson();
            }
            return $occupationQuery->limti($limit)->get();
        }

        if($first){
            if($retJson){
                return $occupationQuery->first()->toJson();
            }
            return $occupationQuery->first();
        }
        if($retJson){
            return $occupationQuery->get()->toJson();
        }
        return $occupationQuery->get();
    }

    public function getRawModel(): Occupation
    {
        return $this->model;
    }

}