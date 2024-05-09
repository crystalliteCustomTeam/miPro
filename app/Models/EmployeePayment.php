<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function empname(): HasOne
    {
        return $this->hasOne(Employee::class,'id','employeeID');
    }
}
