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
        Schema::create('temp_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_products');
    }
};
