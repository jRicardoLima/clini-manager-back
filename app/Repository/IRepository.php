<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IRepository
{
    public function save(Model $obj,bool $retModel = false): bool|Model;
    public function update(Model $obj,int|string $id): bool;
    public function delete(int|string $id,bool $destroy = false): bool;
    public function findId(int|string $id,Collection $join = null,bool $retJson = true): string|Model;
    public function findAll(int $limit = 0,Collection $join = null,bool $retJson = true): string|EloquentCollection;
    public function customSelect(Collection $options,Collection $columns = null,
    Collection $join = null,bool $first = false,
    array $order = [],int $limit = 0,bool $retJson = true): mixed;
    public function getRawModel(): Model;

}