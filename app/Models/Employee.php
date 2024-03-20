<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;


class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = [
        "name",
        "email",
        "extension",
        "password",
        "position",
        "status"
    ];


    public function brandName(): HasOne
    {
        return $this->hasOne(Brand::class,'id','brand');
    }

    public function deparment($employeList)
    {  
       
        return DB::table('departments')->whereJsonContains('users',json_encode($employeList))->get();
        
    }
}
