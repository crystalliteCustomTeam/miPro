<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ClientPayment extends Model
{
    use HasFactory;
    protected $table = 'clientpayment';
    protected $fillable = [
        "clientID",
        "projectID",
        "paymentNature",
        "clientPaid",
        "remainingPayment",
        "paymentGateway",
        "paymentType",
        "ProjectManager",
        "amountShare",
        "created_at",
        "updated_at"
    ];


    public function EmployeeName(): HasOne
    {
        return $this->hasOne(Employee::class,'id','ProjectManager');
    }
}
