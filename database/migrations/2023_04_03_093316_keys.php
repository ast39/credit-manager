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
        Schema::table('credits', function(Blueprint $table) {
            $table->foreign('owner_id', 'credit_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('currency_id', 'credit_currency_key')
                ->references('currency_id')
                ->on('wallet_currencies')
                ->onDelete('cascade');
        });

        Schema::table('credit_calculates', function(Blueprint $table) {
            $table->foreign('owner_id', 'credit_calc_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('currency_id', 'credit_calc_currency_key')
                ->references('currency_id')
                ->on('wallet_currencies')
                ->onDelete('cascade');
        });

        Schema::table('credit_checks', function(Blueprint $table) {
            $table->foreign('owner_id', 'credit_check_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('currency_id', 'credit_check_currency_key')
                ->references('currency_id')
                ->on('wallet_currencies')
                ->onDelete('cascade');
        });

        Schema::table('credit_payments', function(Blueprint $table) {
            $table->foreign('credit_id', 'credit_payment_key')
                ->references('credit_id')
                ->on('credits')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credits', function(Blueprint $table) {
            $table->dropForeign('credit_owner_key');
            $table->dropForeign('credit_currency_key');
        });

        Schema::table('credit_calculates', function(Blueprint $table) {
            $table->dropForeign('credit_calc_owner_key');
            $table->dropForeign('credit_calc_currency_key');
        });

        Schema::table('credit_checks', function(Blueprint $table) {
            $table->dropForeign('credit_check_owner_key');
            $table->dropForeign('credit_check_currency_key');
        });

        Schema::table('credit_payments', function(Blueprint $table) {
            $table->dropForeign('credit_payment_key');
        });
    }
};
