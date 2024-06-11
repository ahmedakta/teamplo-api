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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->string('project_name');
            $table->string('project_description');
            $table->date('project_start_at');
            $table->date('project_end_at');
            $table->integer('project_budget');
            $table->unsignedBigInteger('project_priority');
            $table->unsignedBigInteger('project_stage');
            $table->integer('status');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('project_priority')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('project_stage')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
