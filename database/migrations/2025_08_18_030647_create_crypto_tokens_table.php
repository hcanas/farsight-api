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
        Schema::create('crypto_tokens', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('symbol', 10);
            $table->string('name', 100);
            $table->string('network', 20);
            $table->string('contract_address', 42)->nullable();
            $table->integer('decimals')->default(18);
            $table->bigInteger('last_block')->nullable();
            $table->timestamps();

            $table->unique(['network', 'contract_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_tokens');
    }
};
