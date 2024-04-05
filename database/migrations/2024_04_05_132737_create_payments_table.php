<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("Brand");
            $table->string("Email");
            $table->string("Card_Name");
            $table->string("URL");
            $table->date("Date");
            $table->integer("Total_Amount");
            $table->integer("Paid");
            $table->integer("Balance_Amount");
            $table->string("Sales_Mode");
            $table->string("Platform");
            $table->string("Payment_Gateway");
            $table->string("Card_Brand");
            $table->text("Description");
            $table->string("Transaction_ID");
            $table->string("Sales_Person");
            $table->string("Account_Manager");
            $table->string("Project_Status");
            $table->string("Package_Plan");
            $table->string("Refund_Dispute_Amount");
            $table->Date("Refund_Dispute_Date");
            $table->string("Refund_Dispute_Reason");
            $table->date("Recurring_Renewal");
            $table->Date("Status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
