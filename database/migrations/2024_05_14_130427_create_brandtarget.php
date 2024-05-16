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
        Schema::create('brandtarget', function (Blueprint $table) {
            $table->id();
            $table->integer("BrandID");
            $table->integer('Year');
            $table->integer("January");
            $table->integer("February");
            $table->integer("March");
            $table->integer("April");
            $table->integer("May");
            $table->integer("June");
            $table->integer("July");
            $table->integer("August");
            $table->integer("September");
            $table->integer("October");
            $table->integer("November");
            $table->integer("December");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brandtarget');
    }
};
