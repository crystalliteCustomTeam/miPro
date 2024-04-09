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

    ];

    public function EmployeesName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','ProjectManager');
    }
}
