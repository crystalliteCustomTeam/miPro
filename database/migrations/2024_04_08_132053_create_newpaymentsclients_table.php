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
        Schema::create('newpaymentsclients', function (Blueprint $table) {
            $table->id();
            $table->integer("BrandID");
            $table->integer("ClientID");
            $table->integer("ProjectID");
            $table->integer("ProjectManager");
            $table->string("paymentNature");
            $table->string("ChargingPlan");
            $table->string("ChargingMode");
            $table->string("Platform");
            $table->string("Card_Brand");
            $table->string("Payment_Gateway");
            $table->text("bankWireUpload");
            $table->string("TransactionID");
            $table->date("paymentDate");
            $table->date("futureDate");
            $table->integer("SalesPerson");
            $table->integer("TotalAmount");
            $table->integer("Paid");
            $table->integer("RemainingAmount");
            $table->string("PaymentType");
            $table->string("numberOfSplits");
            $table->json("SplitProjectManager");
            $table->json("ShareAmount");
            $table->text("Description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newpaymentsclients');
    }
};
