<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
