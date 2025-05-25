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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('payment_type', ['cash', 'deferred'])->default('cash');
            $table->enum('payment_status', ['0', '1', '2', '3'])->default('1')->comment("0='paid/', 1='pending/ ', 2='partial/', 3='cancelled/'");
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->decimal('remain_amount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
        
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
