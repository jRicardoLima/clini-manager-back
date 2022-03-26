<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialtie extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "specialtie";
    protected $primaryKey = "id";
    
    protected $fillable = [
        'uuid',
        'name',
        'cbo',
        'subsidiary_id',
    ];

    //Relations

    public function subsidiaryRelation()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id','id');
    }

    public function specialtieHealthProcedureRelation()
    {
        return $this->belongsToMany(HealthProcedure::class,
        'specialtie_health_procedure','specitaltie_id','health_procedure_id');
    }

    public function employeeSpecialtieRelation()
    {
        return $this->belongsToMany(Employee::class,
        'employee_specialtie','specialtie_id','employee_id');
    }
}
