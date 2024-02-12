<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QAFORM extends Model
{
    use HasFactory;
    protected $table = 'qaform';
    protected $fillable = [
        "clientID",
        "projectID",
        "projectmanagerID",
        "brandID",
        "qaformID",
        "ProjectProductionID",
        "status",
        "last_communication",
        "medium_of_communication",
        "client_satisfaction",
        "status_of_refund",
        "Refund_Requested",
        "Refund_Request_Attachment",
        "Refund_Request_summery",
        "qaPerson"



    ];
}
