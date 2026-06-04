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
        Schema::create('new_opportunities', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('customer')->nullable();
            $table->string('interest')->nullable();
            $table->boolean('quote')->nullable();
            $table->integer('projected_value')->nullable();
            $table->date('close_date')->nullable();
            $table->integer('confidence')->nullable();
            $table->string('rep')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_opportunities');
    }
};
