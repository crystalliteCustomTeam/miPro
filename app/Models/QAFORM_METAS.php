<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QAFORM_METAS extends Model
{
    use HasFactory;
    protected $table = 'qaform_metas';
    protected $fillable = [
        "formid",
        "departmant",
        "responsible_person",
        "status",
        "issues",
        "Description_of_issue",
        "evidence"
    ];

    public function EmployeeNameINQA(): HasOne
    {
        return $this->hasOne(Employee::class,'id','responsible_person');
    }
    public function DepartNameINQA(): HasOne
    {
        return $this->hasOne(Department::class,'id','departmant');
    }
}
