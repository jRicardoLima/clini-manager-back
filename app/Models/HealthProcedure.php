<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthProcedure extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "health_procedure";
    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'name',
        'subsidiary_id',
    ];

    //Relations
    public function subsidiaryRelation()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id','id');
    }

    public function specialtieHealthProcedureRelation()
    {
        return $this->belongsToMany(Specialtie::class,
        'specialtie_health_procedure','health_procedure_id','specialtie_id');
    }
}
