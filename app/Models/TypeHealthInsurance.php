<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeHealthInsurance extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "type_health_insurance";
    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'name',
        'subsidiary_id',
    ];

    public function subsidiaryRelation()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id','id');
    }

    public function healthInsuranceRelation()
    {
        return $this->hasOne(HealthInsurance::class,'type_health_insurance_id','id');
    }
}
