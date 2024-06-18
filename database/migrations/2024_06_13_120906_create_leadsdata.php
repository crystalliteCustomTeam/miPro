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
        Schema::create('leadsdata', function (Blueprint $table) {
            $table->id();
            $table->string("Brand")->nullable();
            $table->date("Date")->nullable();
            $table->string("LeadSource")->nullable();
            $table->string("LeadType")->nullable();
            $table->string("ClientName")->nullable();
            $table->string("phone")->nullable();
            $table->string("Email")->nullable();
            $table->string("Service")->nullable();
            $table->string("Attempt_1_agent")->nullable();
            $table->string("Attempt_2_agent")->nullable();
            $table->text("comments")->nullable();
            $table->integer("Amount")->nullable();
            $table->string("keywords")->nullable();
            $table->string("status")->nullable();
            $table->string("GCLID")->nullable();
            $table->string("Locations")->nullable();
            $table->string("MonthofConversion")->nullable();
            $table->string("Region")->nullable();
            $table->string("country")->nullable();
            $table->string("state")->nullable();
            $table->string("other1")->nullable();
            $table->string("other2")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leadsdata');
    }
};
