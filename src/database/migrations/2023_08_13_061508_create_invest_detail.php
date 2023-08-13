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
        Schema::create('invest_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invest_account_id');
            $table->date('deal_at')
                ->comment('交易日');
            $table->unsignedTinyInteger('increment')
                ->comment('序號');
            $table->enum('type', [
                'deposit',
                'withdraw',
                'profit',
                'expense',
            ])
                ->comment('類型');
            $table->unsignedDecimal('amount', 12)
                ->comment('金額');
            $table->unsignedDecimal('balance', 12)
                ->comment('結餘');

            $table->datetime('updated_at');
            $table->datetime('created_at');

            $table->index(['invest_account_id', 'deal_at', 'increment']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_detail');
    }
};
