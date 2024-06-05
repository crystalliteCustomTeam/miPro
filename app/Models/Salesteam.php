<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Salesteam extends Model
{
    use HasFactory;
    protected $table = 'salesteam';
    protected $fillable = [
        "teamLead",
        "members"
    ];

    public function Salesteamleadname(): HasOne
    {
        return $this->hasOne(Employee::class,'id','teamLead');
    }

    public function salesmembers($membersList)
    {
        return DB::table('employees')->whereIn('id',json_decode($membersList))->get();
    }
}
