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
        Schema::create('videoclip', function (Blueprint $table) {
            $table->id();
            $table->string('song');
            $table->string('singer');
            $table->string('description');
            $table->string('views');
            $table->tinyInteger('award')->default('0');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videoclip');
    }
};
