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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();                                            // Primary key
    $table->foreignId('attribute_id')->constrained()         // Foreign key to attributes table
          ->onDelete('cascade');                            
    $table->string('name');                                 // Attribute value in default language (e.g., "Red", "Small")
    $table->string('arName');                               // Attribute value in Arabic
    $table->timestamps();                                    // Created_at and updated_at timestamps
    $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
