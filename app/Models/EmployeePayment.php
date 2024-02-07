<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayment extends Model
{
    use HasFactory;
    protected $table = 'employeepayment';
    protected $fillable = [
        "paymentID",
        "employeeID",
        "paymentDescription",
        "amount"
    ];
}
