<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        "clientID",
        "projectManager",
        "productionID",
        "name",
        "domainOrwebsite",
        "basecampUrl",
        "projectDescription"
    ];


    public function EmployeeName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','projectManager');
    }
    public function ProductionName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','productionID');
    }

    public function ClientName(): HasOne
    {
        return $this->hasOne(Client::class,'id','clientID');
    }
}
