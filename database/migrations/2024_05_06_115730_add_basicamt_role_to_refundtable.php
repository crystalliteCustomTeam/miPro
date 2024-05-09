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
        Schema::table('refundtable', function (Blueprint $table) {
            $table->integer('basicAmount')->nullable()->after('PaymentID');
            $table->integer('clientpaid')->nullable();
            $table->string('paymentType')->nullable()->after('refundReason');
            $table->json('splitmanagers')->nullable();
            $table->json('splitamounts')->nullable();
            $table->json('splitRefunds')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refundtable', function (Blueprint $table) {
            //
        });
    }
};
