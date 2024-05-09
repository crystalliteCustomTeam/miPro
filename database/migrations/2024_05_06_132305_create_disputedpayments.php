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
        Schema::create('disputedpayments', function (Blueprint $table) {
            $table->id();
            $table->integer("BrandID");
            $table->integer("ClientID");
            $table->integer("ProjectID");
            $table->integer("ProjectManager");
            $table->integer("PaymentID");
            $table->date('dispute_Date');
            $table->integer("disputedAmount");
            $table->text("disputeReason");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputedpayments');
    }
};
