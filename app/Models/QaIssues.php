<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QaIssues extends Model
{
    use HasFactory;
    protected $table = 'qa_issues';
    protected $fillable = [
        "departmant",
        "issues",
    ];

    function Issue_Depart():HasOne{
        return $this->hasOne(Department::class,"id","departmant");
    }
}
