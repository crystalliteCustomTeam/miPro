<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    "refundAmount",
    "refundtype",
    "refund_date",
    "refundReason"

    ];
}
