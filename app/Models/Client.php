<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'projectManager',
        'website',
        'basecamp',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'comments'
    ];

    public function findbrand($employeList)
    {
        return DB::table('brands')->where('id',$employeList)->get();
    }
}
