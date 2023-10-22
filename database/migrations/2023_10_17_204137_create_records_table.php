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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_id')->nullable();
            $table->foreignId('card_id')->nullable();
            $table->foreignId('purpose_id')->nullable();
            $table->foreignId('door_id')->nullable();
            $table->string('door_ip')->nullable();
            $table->string('door_name')->nullable();
            $table->boolean('entry')->default(false)->nullable();
            $table->boolean('exit')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
