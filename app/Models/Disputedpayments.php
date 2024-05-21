<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Disputedpayments extends Model
{
    use HasFactory;
    protected $table = 'disputedpayments';
    protected $fillable = [

        "BrandID",
        "ClientID",
        "ProjectID",
        "ProjectManager",
        "PaymentID",
        "dispute_Date",
        "disputedAmount",
        "disputeReason",
        "disputeStatus",
        "disputefee",
        "amt_after_disputefee"

    ];

    public function disputeclientName(): HasOne
    {
        return $this->hasOne(Client::class,'id','ClientID');
    }

    public function disputeprojectName(): HasOne
    {
        return $this->hasOne(Project::class,'id','ProjectID');
    }

    public function disputebrandName(): HasOne
    {
        return $this->hasOne(Brand::class,'id','BrandID');
    }

    public function disputeEmployeeName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','ProjectManager');
    }

    public function disputepayment(): HasOne
    {
        return $this->hasOne(NewPaymentsClients::class,'id','PaymentID');
    }
}
