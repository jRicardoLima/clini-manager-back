<?php
namespace App\Mediators\RepositoryMediators;

use App\Mediators\Mediator;
use App\Repository\AddressRepository;
use App\Repository\IRepository;

final class RepositoryMediator extends Mediator
{   
    public function notifyRepository(IRepository|string $repository,string $action,mixed $data): mixed
    {
        switch($repository){
            case AddressRepository::class:
               return $this->addressMediator($this->factoryRepository($repository),$action,$data);
            break;    
        }
    }
}