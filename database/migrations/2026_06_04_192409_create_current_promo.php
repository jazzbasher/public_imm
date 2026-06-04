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
        Schema::create('current_promo', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('promo_date')->nullable();
            $table->string('customer')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('sample')->nullable();
            $table->string('comments', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_promo');
    }
};
