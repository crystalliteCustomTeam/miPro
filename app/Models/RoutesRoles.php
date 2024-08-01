<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class RoutesRoles extends Model
{
    use HasFactory;
    protected $table = 'routes_roles';
    protected $fillable = [
        "Route",
        "Method",
        "function",
        "Role"
    ];
}
