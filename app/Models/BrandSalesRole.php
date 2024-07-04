<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class BrandSalesRole extends Model
{
    use HasFactory;
    protected $table = 'brand_sales_roles';
    protected $fillable = [
        "Name"  ,
        "Brand" ,
        "Front" ,
        "Support"
    ];


    public function support($membersList)
    {
        return DB::table('employees')->whereIn('id',json_decode($membersList))->get();
    }

    public function rolesBrand():HasOne{
        return $this->hasOne(Brand::class,'id','Brand');
    }
}


