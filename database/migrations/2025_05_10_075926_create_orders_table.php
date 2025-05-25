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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('collected_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('delivered_by')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('tax', 10, 2)->nullable();
            $table->date('order_date');
            $table->enum('order_status', ['0', '1', '2', '3', '4', '5', '6'])->default('0')->comment("0='pending', 1='processing', 2='shipped', 3='delivered', 4='cancelled', 5='returned', 6='partial return'");            
            $table->decimal('additional_tax', 10, 2)->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
