<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $table = 'leadsdata';
    protected $fillable = [
        "Brand",
        "Date",
        "LeadSource",
        "LeadType",
        "ClientName",
        "phone",
        "Email",
        "Service",
        "Attempt_1_agent",
        "Attempt_2_agent",
        "comments",
        "Amount",
        "keywords",
        "status",
        "GCLID",
        "Locations",
        "MonthofConversion",
        "Region",
        "country",
        "state",
        "other1",
        "other2"

    ];
}
