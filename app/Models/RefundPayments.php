<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RefundPayments extends Model
{
    use HasFactory;
    protected $table = 'refundtable';
    protected $fillable = [

    "BrandID",
    "ClientID",
    "ProjectID",
    "ProjectManager",
    "PaymentID",
    "basicAmount",
    "refundAmount",
    "refundtype",
    "refund_date",
    "refundReason",
    "clientpaid",
    "paymentType",
    "splitmanagers",
    "splitamounts",
    "splitRefunds",

    ];

    public function refundEmployeesName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','ProjectManager');
    }


    public function refundbrandName(): HasOne
    {
        return $this->hasOne(Brand::class,'id','BrandID');
    }

    public function refundclientName(): HasOne
    {
        return $this->hasOne(Client::class,'id','ClientID');
    }

    public function refundprojectName(): HasOne
    {
        return $this->hasOne(Project::class,'id','ProjectID');
    }

    public function refundpayment(): HasOne
    {
        return $this->hasOne(NewPaymentsClients::class,'id','PaymentID');
    }
}
