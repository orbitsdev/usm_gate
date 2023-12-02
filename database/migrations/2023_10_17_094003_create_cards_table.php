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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->nullable();
            $table->bigInteger('id_number')->unique()->nullable();
            $table->bigInteger('qr_number')->unique()->nullable();
            $table->date('valid_from')->default(now())->nullable();
            $table->date('valid_until')->default(now()->addYears(1))->nullable();
            $table->string('status')->default('Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
