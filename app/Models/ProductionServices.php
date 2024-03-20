<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductionServices extends Model
{
    use HasFactory;
    protected $table = 'production_services';
    protected $fillable = [
        "department",
        "services",
    ];

    function Prod_Depart():HasOne{
        return $this->hasOne(Department::class,"id","department");
    }
}
