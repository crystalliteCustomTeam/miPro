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
        Schema::table('qaform', function (Blueprint $table) {
            $table->string('client_satisfaction')->nullable()->after('medium_of_communication');
            $table->string('status_of_refund')->nullable();
            $table->string('Refund_Requested')->nullable();
            $table->text('Refund_Request_Attachment')->nullable();
            $table->text('Refund_Request_summery')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qaform', function (Blueprint $table) {
            //
        });
    }
};
