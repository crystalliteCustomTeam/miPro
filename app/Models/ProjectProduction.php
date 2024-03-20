<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProjectProduction extends Model
{
    use HasFactory;
    protected $table = 'project_productions';
    protected $fillable = [
        "clientID",
        "projectID",
        "departmant",
        "responsible_person",
        "services",
        "anycomment",
    ];

    public function EmployeeNameinProjectProduction(): HasOne
    {
        return $this->hasOne(Employee::class,'id','responsible_person');
    }
    public function DepartNameinProjectProduction(): HasOne
    {
        return $this->hasOne(Department::class,'id','departmant');
    }
}
