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
        Schema::create('statement_distribute', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('statement_period');
            $table->unsignedBigInteger('invest_account_id');

            $table->unsignedDecimal('commitment', 12)
                ->comment('計算分配權益');
            $table->unsignedDecimal('weight', 12, 1)
                ->comment('權重');
            $table->decimal('profit', 12)
                ->default(0)
                ->comment('分配損益');

            $table->datetime('updated_at');
            $table->datetime('created_at');

            $table->unique(['statement_period', 'invest_account_id'], 'invest_profit_distribute_period_account_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statement_distribute');
    }
};
