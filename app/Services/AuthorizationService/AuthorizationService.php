<?php

namespace App\Services\AhtorizationService;

use App\Repository\MenuRepository;
use App\Repository\UserRepository;

class AuthorizationService 
{
    private $menu;
    private $user;

    public function __construct(MenuRepository $menu,UserRepository $user)
    {
        $this->menu = $menu;
        $this->user = $user;    
    }

    public function getMenusUsers(int|string $id)
    {
        $userMenu = $this->user->findId($id,false);
    }

    public function getPermissions()
    {

    }


}