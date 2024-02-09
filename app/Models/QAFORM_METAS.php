<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
