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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->string('content_title');
            $table->string('content_image')->nullable();
            $table->string('slug');
            $table->longText('content_body');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->string('seo_keywords');
            $table->boolean('status');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('contents');
            $table->timestamps();
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'department_name'
            ]
        ];
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
