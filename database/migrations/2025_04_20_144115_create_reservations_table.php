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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('amount');
            $table->enum('payment_type', ['Cash', 'Online'])->default('Cash');
            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled'])->default('Pending');
            $table->string('payment_screenshot')->nullable();
            $table->string('reservation_code');
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('futsal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('timeslot_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
