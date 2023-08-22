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
        Schema::create('invest_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invest_account_id');
            $table->date('deal_at')
                ->comment('交易日');
            $table->unsignedTinyInteger('increment')
                ->default(0)
                ->comment('序號');
            $table->enum('type',
                array_keys(
                    config('invest.type')
                )
            )
                ->comment('類型');
            $table->decimal('amount', 12)
                ->comment('金額');
            $table->unsignedDecimal('balance', 12)
                ->default(0)
                ->comment('結餘');

            $table->string('note')
                ->default('')
                ->comment('備註');

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
        Schema::dropIfExists('invest_history');
    }
};
