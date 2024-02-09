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
        Schema::create('qaform_metas', function (Blueprint $table) {
            $table->id();
            $table->string('formid');
            $table->integer('departmant');
            $table->integer('responsible_person');
            $table->string('status');
            $table->json('issues');
            $table->string('Description_of_issue');
            $table->text('evidence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qaform_metas');
    }
};
