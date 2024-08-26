<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Themeselection extends Model
{
    use HasFactory;
    protected $table = 'themeselection';
    protected $fillable = [
        "user",
        "Selectedtheme",
    ];
}
