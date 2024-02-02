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
        Schema::create('user_paymentmetas', function (Blueprint $table) {
            $table->id();
            $table->integer('USERID');
            $table->integer('clientID');
            $table->integer('PROJECTID');
            $table->string('payment_type');
            $table->string('payment_card');
            $table->string('payment_nature');
            $table->double('amountPaid');
            $table->date('payment_date');
            $table->time('payment_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_paymentmetas');
    }
};
