<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invest_monthly_balance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invest_account_id');
            $table->unsignedSmallInteger('year_month');
            $table->unsignedDecimal('deposit', 12);
            $table->unsignedDecimal('withdraw', 12);
            $table->unsignedDecimal('profit', 12);
            $table->unsignedDecimal('expense', 12);
            $table->unsignedDecimal('balance', 12);

            $table->datetime('updated_at');
            $table->datetime('created_at');

            $table->unique(['invest_account_id', 'year_month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_monthly_balance');
    }
};
