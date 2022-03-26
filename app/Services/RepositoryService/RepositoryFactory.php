<?php

namespace App\Services\RepositoryService;

use App\Repository\IRepository;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class RepositoryFactory
{
    private IRepository $repository;
    private Model $model;

    public function __construct(IRepository $repository,Model $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }
    
    public function factory()
    {
        try{
            $reflectionRepository = new ReflectionClass($this->repository);
            $reflectionModel = new ReflectionClass($this->model);

            $nameRepository = $reflectionRepository->getName();
            $nameModel = $reflectionModel->getName();

            return new $nameRepository(new $nameModel);

        }catch(\Exception $ex){
            echo $ex->getMessage();
        }
    }
}