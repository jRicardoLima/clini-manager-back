<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "occupation";
    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'name',
        'cbo',
        'subsidiary_id',        
    ];

    //Relation

    public function subsidiaryRelation()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id','id');
    }

    public function employeeRelation()
    {
        return $this->hasOne(Employee::class,'occupation_id','id');
    }
}
