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
        Schema::create('statement', function (Blueprint $table) {
            $table->unsignedMediumInteger('period')
                ->primary()
                ->comment('對帳單期別');
            $table->unsignedDecimal('commitment', 12)
                ->default(0)
                ->comment('總權益');
            $table->unsignedInteger('weight')
                ->default(0)
                ->comment('總權重');
            $table->decimal('profit', 12)
                ->default(0)
                ->comment('總損益');
            $table->unsignedDecimal('profit_per_weight', 12)
                ->default(0)
                ->comment('每權重損益');
            $table->dateTime('distribute_at')
                ->nullable()
                ->comment('損益分配日期');

            $table->datetime('updated_at');
            $table->datetime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statement');
    }
};
