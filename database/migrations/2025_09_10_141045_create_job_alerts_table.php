<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('job_alerts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('category_id')->nullable();
        $table->unsignedBigInteger('job_type_id')->nullable();
        $table->string('location')->nullable();
        $table->timestamps();

        $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade');

        $table->foreign('category_id')
              ->references('id')->on('categories')
              ->onDelete('set null');

        $table->foreign('job_type_id')
              ->references('id')->on('job_types')
              ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::dropIfExists('job_alerts');
}

};
