<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'brand',
        'frontSeler',
        'website',

    ];

    public function findbrand($employeList)
    {
        return DB::table('brands')->where('id',$employeList)->get();
    }

    public function frontsale():HasOne
    {
        return $this->hasOne(Employee::class,'id','frontSeler');
    }

    public function clientMetas():HasOne
    {
        return $this->hasOne(ClientMeta::class,'clientID','id');
    }

    public function projectbrand():HasOne
    {
        return $this->hasOne(Brand::class,'id','brand');
    }
}
