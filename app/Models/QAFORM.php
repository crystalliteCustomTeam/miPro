<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

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


    function GETDEPARTMENT():HasOne{
        return $this->hasOne(ProjectProduction::class,"id","ProjectProductionID");
    }

    function Project_ProjectManager():HasOne{
        return $this->hasOne(Employee::class,"id","projectmanagerID");
    }

    function QA_Person():HasOne{
        return $this->hasOne(Employee::class,"id","qaPerson");
    }

    function Brand_Name():HasOne{
        return $this->hasOne(Brand::class,"id","brandID");
    }

    function Client_Name():HasOne{
        return $this->hasOne(Client::class,"id","clientID");
    }

    function Project_Name():HasOne{
        return $this->hasOne(Project::class,"id","projectID");
    }

    function QA_META_DATA($id){
        return DB::table('qaform_metas')->where('formid',$id)->get();
    }
}
