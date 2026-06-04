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
        Schema::create('vending_pipeline', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('customer')->nullable();
            $table->string('address')->nullable();
            $table->integer('estimated_spend')->nullable();
            $table->boolean('presentation')->nullable();
            $table->boolean('site_survey')->nullable();
            $table->string('comments', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vending_pipeline');
    }
};
