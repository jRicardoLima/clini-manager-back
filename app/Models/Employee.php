<?php

namespace App\Models;

use App\Events\DeletingAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'employee';
    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'name',
        'identification',
        'salary',
        'professional_register',
        'type_health_professional',
        'subsidiary_id',
        'occupation_id',
        'address_id'
    ];
    

    
    //Relation

    public function subsidiaryRelation()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id','id');
    }

    public function occupationRelation()
    {
        return $this->belongsTo(Occupation::class,'occupation_id','id');
    }

    public function addressRelation()
    {
        return $this->belongsTo(Address::class,'address_id','id');
    }

    public function userRelation()
    {
        return $this->hasOne(User::class,'employee_id','id');
    }

    public function employeeSpecialtieRelation()
    {
        return $this->belongsToMany(Specialtie::class,
        'employee_specialtie','employee_id','specialtie_id');
    }

   protected $dispatchesEvents = [
       'deleting' => DeletingAddress::class
   ];
    
}
