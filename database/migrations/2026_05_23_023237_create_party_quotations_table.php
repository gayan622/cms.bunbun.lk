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
        Schema::create('party_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->enum('event_type', ['office_party', 'birthday_party', 'other']);
            $table->integer('guest_count');
            $table->date('event_date');
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'quoted', 'confirmed', 'cancelled'])->default('new');
            $table->enum('booking_status', [
                'pending',
                'confirmed',
                'rejected',
                'completed'
            ])->default('pending');

            $table->enum('payment_status', [
                'pending',
                'advance_paid',
                'partial_paid',
                'paid'
            ])->default('pending');

            $table->decimal('advance_payment', 10, 2)->default(0);
            $table->decimal('balance_payment', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->time('event_time')->nullable();
            $table->string('hall_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_quotations');
    }
};
