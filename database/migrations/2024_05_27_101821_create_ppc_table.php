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
        Schema::create('ppc', function (Blueprint $table) {
            $table->id();
            $table->string("Campaign_status");
            $table->string("Campaign");
            $table->integer("Budget");
            $table->string("Budget_type");
            $table->string("Optimization_score");
            $table->string("Account");
            $table->string("Campaign_type");
            $table->integer("Interactions");
            $table->integer("Cost");
            $table->integer("Impr");
            $table->string("Bid_strategy_type");
            $table->string("CampaignID");
            $table->text("Clicks");
            $table->string("New_Account")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppc');
    }
};
