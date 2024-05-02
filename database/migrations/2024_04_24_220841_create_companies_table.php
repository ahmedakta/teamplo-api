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
            $table->unsignedBigInteger('user_id');
            $table->string('company_name');
            $table->longText('company_desc')->nullable();
            $table->longText('company_phone')->nullable();
            $table->longText('company_email')->nullable();
            $table->longText('company_website')->nullable();
            $table->string('address')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_country')->nullable();
            $table->integer('status')->default(0);
            // set relations
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
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
