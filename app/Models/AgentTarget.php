<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AgentTarget extends Model
{
    use HasFactory;
    protected $table = 'agenttarget';
    protected $fillable = [

    "AgentID",
    "Year",
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
    "salesrole"
];

public function agentoftarget():HasOne
{
    return $this->hasOne(Employee::class,'id','AgentID');
}

}
