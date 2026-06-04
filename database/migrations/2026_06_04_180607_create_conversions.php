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
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('new_supplier')->nullable();
            $table->string('supplier_converted_from')->nullable();
            $table->integer('annual_opp_volume')->nullable();
            $table->string('supplier_contact_name')->nullable();
            $table->string('end_user')->nullable();
            $table->string('product_converted_to')->nullable();
            $table->string('comments', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversions');
    }
};
