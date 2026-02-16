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
        Schema::table('orders', function (Blueprint $table) {
            // Add order number for reference (useful for both payment methods)
            $table->string('order_number')->unique()->after('id')->nullable();
            
            // Payment related fields
            $table->string('payment_method')->default('stripe')->after('status');
            $table->string('payment_status')->default('pending')->after('payment_method');
            
            // MPESA specific fields
            $table->string('mpesa_receipt_number')->nullable()->after('payment_status');
            $table->string('mpesa_checkout_request_id')->nullable()->after('mpesa_receipt_number');
            $table->string('mpesa_merchant_request_id')->nullable()->after('mpesa_checkout_request_id');
            $table->string('mpesa_phone')->nullable()->after('mpesa_merchant_request_id');
            $table->decimal('mpesa_amount', 10, 2)->nullable()->after('mpesa_phone');
            $table->datetime('mpesa_payment_date')->nullable()->after('mpesa_amount');
            
            // Stripe specific fields (if you want to add them)
            $table->string('stripe_payment_intent')->nullable()->after('mpesa_payment_date');
            $table->string('stripe_payment_method')->nullable()->after('stripe_payment_intent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_number',
                'payment_method',
                'payment_status',
                'mpesa_receipt_number',
                'mpesa_checkout_request_id',
                'mpesa_merchant_request_id',
                'mpesa_phone',
                'mpesa_amount',
                'mpesa_payment_date',
                'stripe_payment_intent',
                'stripe_payment_method'
            ]);
        });
    }
};