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
        Schema::table('disputedpayments', function (Blueprint $table) {
            $table->integer('disputefee')->nullable();
            $table->integer('amt_after_disputefee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disputedpayments', function (Blueprint $table) {
            //
        });
    }
};
