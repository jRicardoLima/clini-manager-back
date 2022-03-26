<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subsidiary extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "subsidiary";
    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'name',
        'identification',
        'cnes',
        'organization_id'
    ];

    //Relations

    public function OrganizationRelation()
    {
        return $this->belongsTo(Organization::class,'organization_id','id');
    }

    public function specialtieRelation()
    {
        return $this->hasOne(Specialtie::class,'subsidiary_id','id');
    }

    public function healthProcedureRelation()
    {
        return $this->hasOne(HealthProcedure::class,'subsidiary_id','id');
    }

    public function healthInsuranceRelation()
    {
        return $this->hasOne(HealthInsurance::class,'subsidiary_id','id');
    }

    public function typeHealthInsuranceRelation()
    {
        return $this->hasOne(TypeHealthInsurance::class,'subsidiary_id','id');
    }

    public function employeeRelation()
    {
        return $this->hasOne(Employee::class,'subsidiary_id','id');
    }

    public function occupationRelation()
    {
        return $this->hasOne(Occupation::class,'subsidiary_id','id');
    }

    public function addressRelation()
    {
        return $this->hasOne(Address::class,'subsidiary_id','id');
    }

    public function userRelation()
    {
        return $this->hasOne(User::class,'subsidiary_id','id');
    }
}
