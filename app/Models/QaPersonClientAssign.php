<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QaPersonClientAssign extends Model
{
    use HasFactory;
    protected $table = 'qaperson_client';
    protected $fillable = [
        "user",
        "client",

    ];

    function Username():HasOne{
        return $this->hasOne(Employee::class,"id","user");
    }

    function clientname():HasOne{
        return $this->hasOne(Client::class,"id","client");
    }
}
