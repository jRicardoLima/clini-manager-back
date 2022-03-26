<?php
namespace App\Repository;

use App\Models\Organization;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class OrganizationRepository implements IRepository
{
    private $model;

    public function __construct(Organization $organization)
    {
        $this->model = $organization;
    }

    public function save(Model $obj,bool $retModel = false): bool | Organization
    {
        $this->model->uuid = Str::uuid();
        $this->model->name = $obj->name;
        $this->model->identification = $obj->identification;
        $this->model->cnes = $obj->cnes;
        $this->model->license = $obj->license;
        $this->model->type_plan = $obj->type_plan;
        $this->model->number_user = $obj->number_user;
        $this->model->number_clinics = $obj->number_clinics;
        $this->model->due_date_license = $obj->due_date_license;

        if($this->model->save() !== true){
            throw new Exception('Erro ao salvar Matriz');
        }

        if($retModel){
           return $this->model;
        }
        return $this->model->save();

    }

    public function update(Model $obj,int|string $id): bool
    {
        $organization = null;

        if(Str::isUuid($id)){
            $organization = $this->model->where("organization.uuid",$id);
        } else {
            $organization = $this->model->fid('organization.id',$id);
        }
        $organization->name = $obj->name;
        $organization->identification = $obj->identification;
        $organization->cnes = $obj->cnes;
        $organization->license = $obj->license;
        $organization->type_plan = $obj->type_plan;
        $organization->number_user = $obj->number_user;
        $organization->number_clinics = $obj->number_clinics;
        $organization->due_date_license = $obj->due_date_license;

        return $organization->save();
    }

    public function delete(int|string $id,bool $destroy = false): bool
    {
        $organization = null;

        if(Str::isUuid($id)){
            $organization = $this->model->where('uuid',$id)->first();

            if($destroy){
                return $organization->forceDelete();
            }
            return $organization->delete();
        }

        $organization = $this->model->find($id);

        if($destroy){
            return $organization->forceDelete();
        }
        return $organization->delete();
    }

    public function findId(int|string $id,Collection $join = null,bool $retJson = true): string
    {
        $organization = $this->model;

        if($join !== null){
            $organization = $organization->with($join->toArray());
        }

        if(Str::isUuid($id)){
            if($retJson){
                $organization =  $organization->where('organization.uuid',$id)->first()->toJson();
            } else {
                $organization = $organization->where('organization.uuid')->first();
            }
        }
        if($retJson){
            $organization = $organization->find($id)->toJson();
        } else {
            $organization = $organization->find($id);
        }
        return $organization;
    }

    public function findAll(int $limit = 0,Collection $join = null,bool $retJson = true): string
    {
        $organization = $this->model;

        if($join !== null){
            $organization = $organization->with($join->toArray());
        }

        if($limit > 0){
            if($retJson){
                $organization =  $organization->limit($limit)->get()->toJson();
            } else {
                $organization = $organization->limit($limit)->get();
            }
        }
        if($retJson){
            $organization =  $organization->get()->toJson();
        } else {
            $organization = $organization->get();
        }
        return $organization;
    }

    public function customSelect(Collection $options,Collection $columns = null,
    Collection $join = null,bool $first = false,array $order = [],
    int $limit = 0,bool $retJson = true): mixed
    {
        $organizationQuery = $this->model;

        if($columns !== null){
            $organizationQuery = $organizationQuery->addSelect($columns->toArray());
        }

        if($join){
            $organizationQuery = $organizationQuery->with($join->toArray());
        }

        if($options->has('id')){
            $organizationQuery = $organizationQuery->where('organization.id',$options->get('id'));
        }

        if($options->has('uuid')){
            $organizationQuery = $organizationQuery->where('organization.uuid',$options->get('uuid'));
        }

        if($options->has('name')){
            $organizationQuery = $organizationQuery->where('organization.name','LIKE','
                                                          %'.$options->get('name').'%');
        }

        if($options->has('identification')){
            $organizationQuery = $organizationQuery->where('organization.identification',
                                                          $options->get('identification'));
        }

        if($options->has('cnes')){
            $organizationQuery = $organizationQuery->where('organization.cnes',
                                                          $options->get('cnes'));
        }

        if($options->has('license')){
            $organizationQuery = $organizationQuery->where('organization.license',
                                                           $options->get('license'));
        }

        if($options->has('type_plan')){
            $organizationQuery = $organizationQuery->where('organization.type_plan',
                                                           $options->get('type_plan'));

        }

        if($options->has('number_user')){
            $organizationQuery = $organizationQuery->where('organization.number_user',
                                                          $options->get('number_user'));
        }

        if($options->has('number_clinics')){
            $organizationQuery = $organizationQuery->where('organization.number_clinics',
                                                          $options->get('number_clinics'));
        }

        if($options->has('due_date_license')){
            $organizationQuery = $organizationQuery->where('organization.due_date_license',
            $options->get('due_date_license'));
        }

        if($options->has('due_date_license_min') && $options->has('due_date_license_max')){
            $organizationQuery = $organizationQuery->whereBetween('organization.due_date_license',
                                                                 [$options->get('due_date_license_min'),
                                                                 $options->get('due_date_license_max')]);
        }

        if($order !== []){
            if(count($order) > 1){

                foreach($order as $key => $value){
                    $organizationQuery = $organizationQuery->orderBy($value);
                }
            } else {
                $organizationQuery = $organizationQuery->orderBy($order[0]);
            }  
        }

        if($limit > 0){
            if($first){
                if($retJson){
                    return $organizationQuery->first()->toJson();
                }
                return $organizationQuery->first();
            }
            if($retJson){
                $organizationQuery->limit($limit)->get()->toJson();
            }
            return $organizationQuery->limit($limit)->get();
        }

        if($first){
            if($retJson){
                return $organizationQuery->first()->toJson();
            }
            return $organizationQuery->first();
        }
        if($retJson){
            return $organizationQuery->get()->toJson();
        }
        return $organizationQuery->get();
    }

    public function getRawModel(): Organization
    {
        return $this->model;
    }
}