<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $table = 'Payments';
    protected $fillable = [
     "Brand",
     "Email",
     "Card_Name",
     "URL",
     "Date",
     "Total_Amount",
     "Paid",
     "Balance_Amount",
     "Sales_Mode",
     "Platform",
     "Payment_Gateway",
     "Card_Brand",
     "Description",
     "Transaction_ID",
     "Sales_Person",
     "Account_Manager",
     "Project_Status",
     "Package_Plan",
     "Refund_Dispute_Amount",
     "Refund_Dispute_Date",
     "Refund_Dispute_Reason",
     "Recurring_Renewal",
     "Status"

    ];
}
