<?php
namespace App\Repository;

use App\Models\Address;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class AddressRepository implements IRepository
{
    private $model;

    public function __construct(Address $address)
    {
        $this->model = $address;
    }

    public function save(Model $obj,bool $retModel = false): bool | Address
    {
        $this->model->uuid = Str::uuid();
        $this->model->city = $obj->city;
        $this->model->zipcode = $obj->zipcode;
        $this->model->street = $obj->street;
        $this->model->neighborhood = $obj->neighborhood;
        $this->model->number = $obj->number;
        $this->model->federative_unit = $obj->federative_unit;
        $this->model->telphone_one = $obj->telphone_one;
        $this->model->telphone_two = $obj->telphone_two;
        $this->model->email = $obj->email;
        $this->model->subsidiary_id = $obj->subsidiary_id;

        if($this->model->save() !== true){
            return throw new Exception('Erro ao salvar o Endereço');
        }
        if($retModel){
            return $this->model;
        }
        return true;
    }

    public function update(Model $obj,int|string $id): bool
    {
        $address = null;

        if(Str::isUuid($id)){
            $address = $this->model->where('uuid',$id)->first();
        } else {
            $address = $this->model->find($id);
        }

        $address->city = $obj->city;
        $address->zipcode = $obj->zipcode;
        $address->street = $obj->street;
        $address->neighborhood = $obj->neighborhood;
        $address->number = $obj->number;
        $address->federative_unit = $obj->federative_unit;
        $address->telphone_one = $obj->telphone_one;
        $address->telphone_two = $obj->telphone_two;
        $address->email = $obj->email;
        $address->subsidiary_id = $obj->subsidiary_id;
        
        return $address->save();
    }

    public function delete(int|string $id,bool $destroy = false): bool
    {
        $address = null;
        
        if(Str::isUuid($id)){
            $address = $this->model->where('uuid',$id)->first();
        } else {
            $address = $this->model->find($id);
        }

        if($destroy){
            return $address->forceDelete();
        }
        return $address->delete();
        
    }

    public function findId(int|string $id,Collection $join = null,bool $retJson = true): string
    {
        $address = $this->model;

        if($join !== null){
            $address = $address->with($join->toArray());
        }
        if(Str::isUuid($id)){
            if($retJson){
                $address = $address->where('address.uuid',$id)->first()->toJson();
            } else {
                $address = $address->where('address.uuid',$id)->first();
            }  
        }

        if($retJson){
            $address = $address->find($id)->toJson();
        } else {
            $address = $address->find($id);
        }
        return $address;
       
    }

    public function findAll(int $limit = 0,Collection $join = null,bool $retJson = true): string|EloquentCollection
    {
        $address = $this->model;

        if($join !== null){
            $address = $address->with($join->toArray());
        }

        if($limit > 0){
            if($retJson){
                $address = $address->limit($limit)->get()->toJson();
            } else {
                $address = $address->limit($limit)->get();
            }
            
            
        }
        if($retJson){
            $address = $address->get()->toJson();
        } else {
            $address = $address->get();
        }
        return $address;
    }

    public function customSelect(Collection $options,Collection $columns = null,
    Collection $join = null,bool $first = false,array $order = [],
    int $limit = 0,bool $retJson = true): mixed
    {
        $addressQuery = $this->model;

        if($columns !== []){
            $addressQuery = $addressQuery->addSelect($columns->toArray());
        }

        if($join){
           $addressQuery = $addressQuery->with($join->toArray());
        }

        if($options->has('id')){
            $addressQuery = $addressQuery->where('address.id',$options->get('id'));
        }

        if($options->has('uuid')){
            $addressQuery = $addressQuery->where('address.uuid',$options->get('uuid'));
        }

        if($options->has('city')){
            $addressQuery = $addressQuery->where('address.city','LIKE',
                                                '%'.$options->get('city').'%');
        }

        if($options->has('street')){
            $addressQuery = $addressQuery->where('address.street','LIKE',
                                                '%'.$options->get('street').'%');
        }

        if($options->has('neighborhood')){
            $addressQuery = $addressQuery->where('address.neighborhood','LIKE',
                                                '%'.$options->get('neighborhood').'%');
        }

        if($options->has('number')){
            $addressQuery = $addressQuery->where('address.number',$options->get('number'));
        }

        if($options->has('zipcode')){
            $addressQuery = $addressQuery->where('address.zipcode',$options->get('zipcode'));
        }

        if($options->has('federative_unit'))
        {
            $addressQuery = $addressQuery->where('address.federative_unit',
                                                $options->get('federative_unit'));
        }

        if($options->has('telphone_one')){
            $addressQuery = $addressQuery->where('address.telphone_one',
                                                $options->get('telphone_one'));
        }

        if($options->has('telphone_two')){
            $addressQuery = $addressQuery->where('address.telphone_two',
                                                $options->get('telphone_two'));
        }

        if($options->has('email')){
            $addressQuery = $addressQuery->where('address.email',$options->get('email'));
        }

        if($options->has('subsidiary_id')){
            $addressQuery = $addressQuery->where('address.subsidiary_id',
                                                $options->get('subsidiary_id'));
        }

        if($order !== []){
            if(count($order) > 1){
                
                foreach($order as $key => $value){
                    $addressQuery = $addressQuery->orderBy($value);
                }
            }
            $addressQuery = $addressQuery->orderBy($order[0]);
        }

        if($limit > 0){

            if($first){
                if($retJson){
                    return $addressQuery->first()->toJson();
                }
                return $addressQuery->first();
                
            }
            if($retJson){
                return $addressQuery->limit($limit)->get()->toJson();
            }
            return $addressQuery->limit($limit)->get();
        }

        if($first){
            if($retJson){
                return $addressQuery->first()->toJson();
            }
            return $addressQuery->first();
        }
        
        if($retJson){
            $addressQuery->get()->toJson();
        }
        return $addressQuery->get();
    }

    public function getRawModel(): Address
    {
        return $this->model;
    }
}