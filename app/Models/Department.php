<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $fillable = [
        "name",
        "manager",
        "users"
    ];

    public function UserName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','manager');
    }

    public function findEmp($employeList)
    {
        return DB::table('employees')->whereIn('id',json_decode($employeList))->get();
    }
   
}
