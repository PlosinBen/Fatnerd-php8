<?php

use App\Models\StatementFutures;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statement_futures', function (Blueprint $table) {
            $table->id();

            $table->unsignedMediumInteger('period');
            $table->string('group');

            $table->unsignedDecimal('commitment', 12)
                ->comment('期末權益');
            $table->decimal('open_profit', 12)
                ->comment('未平倉損益');
            $table->decimal('close_profit', 12)
                ->nullable()
                ->comment('沖銷損益');
            $table->unsignedDecimal('deposit', 12)
                ->comment('入金');
            $table->unsignedDecimal('withdraw', 12)
                ->comment('出金')
                ->comment('實質權益(權益數-未平倉損益-出入金淨額[入金-出金])');
            $table->unsignedDecimal('real_commitment', 12)
                ->default(0);
            $table->decimal('commitment_profit', 12)
                ->default(0)
                ->comment('權益損益');
            $table->decimal('profit', 12)
                ->default(0)
                ->comment('最終損益');

            $table->datetime('updated_at');
            $table->datetime('created_at');

            $table->unique(['period', 'group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statement_futures');
    }
};
