<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NewPaymentsClients extends Model
{
    use HasFactory;
    protected $table = 'newpaymentsclients';
    protected $fillable = [
        "BrandID",
        "ClientID",
        "ProjectID",
        "ProjectManager",
        "paymentNature",
        "ChargingPlan",
        "ChargingMode",
        "Platform",
        "Card_Brand",
        "Payment_Gateway",
        "bankWireUpload",
        "TransactionID",
        "paymentDate",
        "futureDate",
        "SalesPerson",
        "TotalAmount",
        "Paid",
        "RemainingAmount",
        "PaymentType",
        "numberOfSplits",
        "SplitProjectManager",
        "ShareAmount",
        "Description",
        "refundStatus",
        "remainingID",
        "remainingStatus",
        "transactionType"

    ];

    public function pmEmployeesName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','ProjectManager');
    }

    public function saleEmployeesName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','SalesPerson');
    }

    public function paymentbrandName(): HasOne
    {
        return $this->hasOne(Brand::class,'id','BrandID');
    }

    public function paymentclientName(): HasOne
    {
        return $this->hasOne(Client::class,'id','ClientID');
    }

    public function paymentprojectName(): HasOne
    {
        return $this->hasOne(Project::class,'id','ProjectID');
    }
}
