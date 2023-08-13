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
        Schema::create('invest_statement', function (Blueprint $table) {
            $table->unsignedMediumInteger('period')->primary();

            $table->string('asset_type')
                ->comment('資產類別');
            $table->decimal('base_profit', 12)
                ->comment('原幣別損益');
            $table->decimal('profit', 12)
                ->comment('轉換後損益');

            $table->datetime('updated_at');
            $table->datetime('created_at');

            $table->unique(['period', 'asset_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_statement');
    }
};
