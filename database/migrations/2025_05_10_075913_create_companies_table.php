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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('arName');
            $table->text('address')->nullable();
            $table->text('arAddress')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string("industry")->nullable();
            $table->string("arIndustry")->nullable();
            $table->string('commercial_registration_number')->nullable();
            $table->string('commercial_registration_image')->nullable();
            $table->string('tax_id')->nullable(); 
            $table->string('tax_image')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->foreignId('discount_type_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId("created_by")->constrained("users");
            $table->boolean("status")->default(1);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
