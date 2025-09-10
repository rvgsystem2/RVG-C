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
        Schema::create('payment_orders', function (Blueprint $table) {
         
            $table->id();

            // Link-based payment (admin-generated secure link)
            $table->string('link_token', 64)->unique()->nullable();

            // Relations
            $table->foreignId('package_id')->nullable()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()
                ->constrained('users')->nullOnDelete();

            // Customer info
            $table->string('name')->nullable();
            $table->string('phone', 20);                  // store as 91XXXXXXXXXX (no +)
            $table->string('business_name')->nullable();

            // Money fields
            $table->decimal('amount', 10, 2)->nullable(); // base amount (from package)
            $table->enum('discount_type', ['none', 'flat', 'percent'])->default('none');
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('amount_payable', 10, 2)->nullable(); // computed final
            $table->string('currency', 10)->default('INR');

            // Optional reason/note
            $table->string('discount_reason')->nullable();

            // Razorpay refs
            $table->string('razorpay_order_id')->nullable()->index();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();


            $table->enum('status', ['created', 'paid', 'failed'])->default('created');
            $table->json('meta')->nullable();


            $table->timestamp('expires_at')->nullable();

            $table->timestamps();


            $table->index(['phone', 'status']);
            $table->index(['package_id', 'status']);
            
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_orders');
    }
};
