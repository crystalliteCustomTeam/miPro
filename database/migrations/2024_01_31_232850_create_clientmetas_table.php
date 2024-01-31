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
        Schema::create('clientmetas', function (Blueprint $table) {
            $table->id();
            $table->integer('clientID');
            $table->string('service');
            $table->string('packageName');
            $table->double('amountPaid');
            $table->double('remainingAmount');
            $table->date('nextPayment');
            $table->string('paymentRecuring');
            $table->json('orderDetails');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientmetas');
    }
};
