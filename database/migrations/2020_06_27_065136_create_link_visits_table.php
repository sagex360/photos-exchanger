<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateLinkVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('link_visits', static function (Blueprint $table) {
            $table->id();

            $table->foreignId('link_token_id')
                ->constrained('link_tokens')
                ->onUpdate('restrict')
                ->onDelete('cascade');

            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('link_visits');
    }
}
