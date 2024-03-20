<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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

    // public function projectrBrand(): HasOneThrough
    // {
    //     return $this->hasOneThrough(
    //         Project::class,
    //         Client::class,
    //         'brand', // Foreign key on the Client table...
    //         'clientID', // Foreign key on the Project table...
    //         'id', // Local key on the Brand table...
    //         'id' // Local key on the carsClient table...
    //     );
    // }
}
//  brand_id -> client_brand,id -> project_clientID



//     brand
//     id - integer
//     name - string

//     client
//     id - integer
//     model - string
//     brand - integer

//     project
//     id - integer
//     name - string
//     clientID - integer

//     public function projectBrand(): HasOneThrough
//     {
//         return $this->hasOneThrough(
//             project::class,
//             client::class,
//             'brand', // Foreign key on the cars table...
//             'clientID', // Foreign key on the owners table...
//             'id', // Local key on the mechanics table...
//             'id' // Local key on the cars table...
