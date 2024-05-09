<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientMeta extends Model
{
    use HasFactory;
    protected $table = 'clientmetas';
    protected $fillable = [
        'clientID',
        'service',
        'packageName',
        'amountPaid',
        'remainingAmount',
        'nextPayment',
        'paymentRecuring',
        'orderDetails',
        'otheremail'
    ];

}
