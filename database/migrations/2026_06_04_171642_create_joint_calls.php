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
        Schema::create('joint_calls', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('customer_name')->nullable();
            $table->string('vendor')->nullable();
            $table->string('vendor_rep')->nullable();
            $table->date('date_worked')->nullable();
            $table->string('comments', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joint_calls');
    }
};
