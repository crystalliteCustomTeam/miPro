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
        Schema::table('newpaymentsclients', function (Blueprint $table) {
            $table->integer('dateDifference')->nullable()->after('transactionType');
            $table->date('oldExpecteddate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newpaymentsclients', function (Blueprint $table) {
            //
        });
    }
};
