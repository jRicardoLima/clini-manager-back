<?php
namespace App\Mediators;

interface IAcceptMediator
{
    public function notifyMediator(mixed $mediator): mixed;
}