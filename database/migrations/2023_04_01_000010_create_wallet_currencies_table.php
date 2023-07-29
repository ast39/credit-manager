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
        Schema::create('wallet_currencies', function (Blueprint $table) {
            $table->id('currency_id')
                ->comment('ID валюты');

            $table->string('title')
                ->comment('Название валюты');

            $table->string('abbr')
                ->comment('Аббревиатура - сокращение валюты');

            $table->unsignedTinyInteger('status')
                ->default(1);

            $table->timestamps();

            $table->comment('Валюты кошельков');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_currencies');
    }
};
