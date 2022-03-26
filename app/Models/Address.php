<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'address';
    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid',
        'city',
        'zipcode',
        'street',
        'neighborhood',
        'number',
        'federative_unit',
        'telphone_one',
        'telphone_two',
        'email',
        'subsidiary_id'        
    ];

    //Relation

    public function subsidiaryRelation()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id','id');
    }

    public function employeeRelation()
    {
        return $this->hasOne(Employee::class,'address_id','id');
    }

    public function healthInsuranceRelation()
    {
        return $this->hasOne(HealthInsurance::class,'address_id','id');
    }
}
