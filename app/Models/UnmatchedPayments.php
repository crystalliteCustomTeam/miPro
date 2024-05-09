<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnmatchedPayments extends Model
{
    use HasFactory;
    protected $table = 'unmatched_payments';
    protected $fillable = [
        "TransactionID",
        "Clientemail",
        "paymentDate",
        "Paid",
        "Description",
        "cardBrand",
        "stripePaymentstatus"
    ];
}
