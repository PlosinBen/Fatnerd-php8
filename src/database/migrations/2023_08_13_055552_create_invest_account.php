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
        Schema::create('invest_account', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')
                ->nullable();
            $table->string('alias');
            $table->string('contract')
                ->nullable()
                ->comment('合約類型');

            $table->unsignedMediumInteger('start_period')
                ->comment('投資開始年月');
            $table->unsignedMediumInteger('end_period')
                ->nullable()
                ->comment('投資結束年月');

            $table->datetime('updated_at');
            $table->datetime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_account');
    }
};
