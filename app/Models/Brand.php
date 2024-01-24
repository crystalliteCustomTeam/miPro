<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected $fillable = [
        "companyID"      ,
        "name"      ,
        "website"   ,
        "tel"       ,
        "email"     ,
        'brandOwner',
        "address"   ,
        "status"
    ];

    public function brandOwnerName():HasOne{
        return $this->hasOne(Employee::class,'id','brandOwner');
    }
}
