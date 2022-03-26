<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthInsurance extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "health_insurance";
    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'name',
        'subsidiary_id',
        'type_health_insurance_id',
    ];

    //Relations

    public function subsidiaryRelation()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id','id');
    }

    public function typeHealthInsuranceRelation()
    {
        return $this->belongsTo(TypeHealthInsurance::class,'type_health_insurance_id','id');
    }

    public function addressRelation()
    {
        return $this->belongsTo(Address::class,'address_id','id');
    }
}
