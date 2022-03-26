<?php
namespace App\Repository;

use App\Models\Menu;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
class MenuRepository implements IRepository
{
    private $model;

    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    public function save(Model $obj,bool $retModel = false): bool | Menu 
    {
        $this->model->uuid = Str::uuid();
        $this->model->label = $obj->label;
        $this->model->icon = $obj->icon;
        $this->model->command = $obj->command;
        $this->model->module = $obj->module;

        if($this->model->save() !== true){
            throw new Exception('Erro ao salvar Menu');
        }

        if($retModel){
           return $this->model;
        }
        return $this->model->save();
    }

    public function update(Model $obj,int|string $id): bool
    {
        $menu = null;
        if(Str::isUuid($id)){
           $menu = $this->model->where('menu.uuid',$id)->first();
        } else {
            $menu = $this->model->find($id);
        }
        $menu->label = $obj->label;
        $menu->icon = $obj->icon;
        $menu->command = $obj->command;
        $menu->module = $obj->module;
        return $menu->save();
    }

    public function delete(int|string $id,bool $destroy = false): bool
    {
        $menu = null;

        if(Str::isUuid($id)){
            $menu = $this->model->where('menu.uuid',$id)->first();

            if($destroy){
                return $menu->forceDelete();
            }
            return $menu->delete();
        }
        $menu = $this->model->find($id);

        if($destroy){
            $menu->forceDelete();
        }
        return $menu->delete();
    }

    public function findId(int|string $id,Collection $join = null,bool $retJson = true): string 
    {
        $menu = $this->model;

        if($join !== null){
            $menu = $menu->with([$menu->toArray()]);
        }

        if(Str::isUuid($id)){
            if($retJson){
               $menu = $menu->where('menu.uuid',$id)->first()->toJson();
            } else {
               $menu = $menu->where("menu.uuid",$id)->first();
            }  
        }
        if($retJson){
            $menu = $menu->find($id)->toJson();
        } else {
            $menu = $menu->find($id);
        }
        return $menu;
        
    }

    public function findAll(int $limit = 0,Collection $join = null,bool $retJson = true): string
    {
        $menu = $this->model;

        if($join !== null){
            $menu = $menu->with([$join->toArray()]);
        }

        if($limit > 0){
            if($retJson){
                $menu = $menu->limit($limit)->get()->toJson();
            } else {
                $menu = $menu->limit($limit)->get();
            }
        }
        if($retJson){
            $menu = $menu->get()->toJson();
        } else {
            $menu = $menu->get();
        }
        return $menu;        
    }

    public function customSelect(Collection $options,Collection $columns = null,
    Collection $join = null,bool $first = false,array $order = [],
    int $limit = 0,bool $retJson = true): mixed 
    {
        $menuQuery = $this->model;

        if($columns != null){
            $menuQuery = $menuQuery->addSelect($columns->toArray());
        }

        if($join !== null){
           $menuQuery = $menuQuery->with([$join->toArray()]);
        }

        if($options->has('id')){
            $menuQuery = $menuQuery->where('menu.id',$options->get('id'));
        }

        if($options->has('uuid')){
            $menuQuery = $menuQuery->where('menu.uuid',$options->get('uuid'));
        }

        if($options->has('label')){
            $menuQuery = $menuQuery->where('menu.label',$options->get('label'));
        }

        if($options->has('icon')){
            $menuQuery = $menuQuery->where('menu.icon',$options->get('icon'));
        }

        if($options->has('command')){
            $menuQuery = $menuQuery->where('menu.command',$options->get('command'));
        }

        if($options->has('module')){
            $menuQuery = $menuQuery->where('menu.module',$options->get('module'));
        }

        if($order !== []){
            if(count($order) > 1){
                foreach($order as $key => $value){
                    $menuQuery = $menuQuery->orderBy($value);
                }
            } else {
                $menuQuery = $menuQuery->orderBy($order[0]);
            }
        }

        if($limit > 0){
           
            if($first){
                if($retJson){
                    return $menuQuery->first()->toJson();
                }
                return $menuQuery->first();
            }
            if($retJson){
                return $menuQuery->limit($limit)->get()->toJson();
            }
            return $menuQuery->limit($limit)->get();
        }

        if($first){
           if($retJson){
            return $menuQuery->first()->toJson(); 
           }
           return $menuQuery->first();  
               
        }
        if($retJson){
            return $menuQuery->get()->toJson(); 
        }
        return $menuQuery->get();


    }

    public function getRawModel(): Menu
    {
        return $this->model;
    }
}