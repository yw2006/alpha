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
        Schema::create('price_request_rejections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_requested')->constrained('price_requests')->onDelete('cascade');
            $table->text('note');
            $table->string('status_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_request_rejections');
    }
};
