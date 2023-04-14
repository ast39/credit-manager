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
        });

        Schema::table('credit_calculates', function(Blueprint $table) {
            $table->foreign('owner_id', 'credit_calc_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('credit_checks', function(Blueprint $table) {
            $table->foreign('owner_id', 'credit_check_owner_key')
                ->references('id')
                ->on('users')
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
        //
    }
};
