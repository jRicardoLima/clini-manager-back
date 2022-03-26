<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "organization";
    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid',
        'name',
        'identification',
        'cnes',
        'license',
        'type_plan',
        'number_user',
        'number_clinics',
        'due_date_license'
    ];

    //Relations

    public function subsidiaryRelation()
    {
        return $this->hasOne(Subsidiary::class,'organiation_id','id');
    }
    
}
