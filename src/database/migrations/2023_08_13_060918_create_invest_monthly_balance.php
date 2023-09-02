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
            $table->unsignedMediumInteger('period');

            $table->decimal('deposit', 12)
                ->default(0)
                ->comment('入金');
            $table->decimal('transfer', 12)
                ->default(0)
                ->comment('出金轉存');
            $table->decimal('withdraw', 12)
                ->default(0)
                ->comment('出金');

//            $table->decimal('commitment')
//                ->default(0)
//                ->comment('可分配權益');
//            $table->unsignedInteger('weight')
//                ->default(0)
//                ->comment('權重');

            $table->decimal('profit', 12)
                ->default(0)
                ->comment('損益分配');
            $table->decimal('expense', 12)
                ->default(0)
                ->comment('費用');

            $table->decimal('balance', 12)
                ->default(0)
                ->comment('結餘');

            $table->datetime('updated_at');
            $table->datetime('created_at');

            $table->unique(['invest_account_id', 'period']);
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
