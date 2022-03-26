<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "menu";
    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'label',
        'icon',
        'command'
    ];

    //Relations

    public function userRelation()
    {
        return $this->belongsToMany(User::class,'menu_user','menu_id','user_id');
    }

    
}
