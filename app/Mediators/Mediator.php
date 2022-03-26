<?php
namespace App\Mediators;

use App\Models\Address;
use App\Repository\AddressRepository;
use App\Repository\IRepository;
use Exception;
use Illuminate\Support\Facades\App;
use ReflectionClass;

abstract class Mediator
{
    abstract public function notifyRepository(IRepository $repository,string $action,mixed $data): mixed;

    protected function factoryRepository(string $repository): IRepository
    {
        $reflection = new ReflectionClass($repository);

        if(array_search("App\Repository\IRepository",$reflection->getInterfaceNames()) !== false){
            return App::make(AddressRepository::class);
        } else {
            return throw new Exception("Erro ao gerar gerar o repositório (Mediator class)");
        }
    }

    protected function addressMediator(IRepository $repository,string $action,Address $data)
    {
        if($action === 'save'){
            return $repository->save($data,true);
        } else if ($action === 'update'){
            return $repository->update($data,$data->id);
        } else if ($action === 'delete'){
            return $repository->delete($data->id);
        } else if($action === 'delete_destroy') {
            return $repository->delete($data->id,true);
        } else {
            throw new \Exception('Notificação do endereço não encontrado');
        }
    }

}