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
        Schema::create('project_productions', function (Blueprint $table) {
            $table->id();
            $table->integer('clientID');
            $table->string('projectID');
            $table->integer('departmant');
            $table->integer('responsible_person');
            $table->json('services')->nullable();
            $table->string('anycomment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_productions');
    }
};
