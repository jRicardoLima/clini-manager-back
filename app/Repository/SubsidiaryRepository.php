<?php
namespace App\Repository;

use App\Models\Subsidiary;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class SubsidiaryRepository implements IRepository
{
    private $model;

    public function __construct(Subsidiary $subsidiary)
    {
        $this->model = $subsidiary;
    }

    public function save(Model $obj,bool $retModel = false): bool | Subsidiary
    {
        $this->model->uuid = Str::uuid();
        $this->model->name = $obj->name;
        $this->model->identification = $obj->identification;
        $this->model->cnes = $obj->cnes;
        $this->model->organization_id = $obj->organization_id;

        if($this->model->save() !== true){
            throw new Exception('Erro ao salvar Filial');
        }
        if($retModel){
            return $this->model;
        }
        return true;
    }
    
    public function update(Model $obj,mixed $id): bool
    {
        $subsidiary = null;

        if(Str::isUuid($id)){
            $subsidiary = $this->model->where('subsidiary.uuid',$id)->first();
        } else {
            $subsidiary = $this->model->find($id);
        }

        $subsidiary->name = $obj->name;
        $subsidiary->cnes = $obj->cnes;
        
        return $subsidiary->save();
    }

    public function delete(int|string $id,bool $destroy = false): bool
    {
        $subsidiary = null;

        if(Str::isUuid($id)){
            $subsidiary = $this->model->where('uuid',$id)->first();

            if($destroy){
                return $subsidiary->forceDelete();
            }
            return $subsidiary->delete();
        }
        $subsidiary = $this->model->find($id);
        
        if($destroy){
            return $subsidiary->forceDelete(); 
        }
        return $subsidiary->delete();
    }

    public function findId(int|string $id,Collection $join = null,bool $retJson = true): string 
    {
        $subsidiary = $this->model;

        if($join !== null){
            $subsidiary = $subsidiary->with($subsidiary->toJson());
        }

        if(Str::isUuid($id)){
            if($retJson){
                $subsidiary =  $subsidiary->where('subsidiary.uuid',$id)->first()->toJson();
            } else {
                $subsidiary = $subsidiary->where('subsidiary.uuid',$id)->first();
            }
        }
        if($retJson){
            $subsidiary = $subsidiary->find($id)->toJson();
        } else {
            $subsidiary = $subsidiary->find($id);
        }
        return $subsidiary;
    }

    public function findAll(int $limit = 0,Collection $join = null,bool $retJson = true): string 
    {
        $subsidiary = $this->model;

        if($join !== null){
            $subsidiary = $subsidiary->with($join->toArray());
        }

        if($limit > 0){
            if($retJson){
                $subsidiary = $subsidiary->limit($limit)->get()->toJson();
            } else {
                $subsidiary = $subsidiary->limit($limit)->get();
            }
        }

        if($retJson){
            $subsidiary = $subsidiary->get()->toJson();
        } else {
            $subsidiary = $subsidiary->get();
        }
        return $subsidiary;
    }

    public function customSelect(Collection $options,Collection $columns = null,
    Collection $join = null,bool $first = false,array $order = [],
    int $limit = 0,bool $retJson = true): mixed
    {
        $subsidiaryQuery = $this->model;

        if($columns !== null){
            $subsidiaryQuery = $subsidiaryQuery->addSelect($columns->toArray());
        }

        if($join !== null){
            $subsidiaryQuery = $subsidiaryQuery->with($join->toArray());
        }

        if($options->has('id')){
            $subsidiaryQuery = $subsidiaryQuery->where('subsidiary.id',$options->get('id'));
        }

        if($options->has('uuid')){
            $subsidiaryQuery = $subsidiaryQuery->where('subsidiary.uuid',$options->get('uuid'));
        }

        if($options->has('name')){
            $subsidiaryQuery = $subsidiaryQuery->where('subsidiary.name','LIKE',
                                                     '%'.$options->get('name').'%');
        }

        if($options->has('cnes')){
            $subsidiaryQuery = $subsidiaryQuery->where('subsidiary.cnes',$options->get('cnes'));
        }

        if($order !== []){

            if(count($order) > 1){

                foreach($order as $key => $value){
                    $subsidiaryQuery = $subsidiaryQuery->orderBy($value);
                }
            }
            $subsidiaryQuery->orderBy($order[0]);
        }

        if($limit > 0){

            if($first){
                if($retJson){
                    return $subsidiaryQuery->first()->toJson();
                }
                return $subsidiaryQuery->first();
            }
            if($retJson){
                return $subsidiaryQuery->limit($limit)->get()->toJson();
            }
            return $subsidiaryQuery->limit($limit)->get();
        }

        if($first){
            if($retJson){
                return $subsidiaryQuery->first()->toJson();
            }
            return $subsidiaryQuery->first();
        }
        if($retJson){
            return $subsidiaryQuery->get()->toJson();
        }
        return $subsidiaryQuery->get();
    }

    public function getRawModel(): Subsidiary
    {
        return $this->model;
    }


}