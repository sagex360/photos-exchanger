<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToFilesTable extends Migration
{
    public function up(): void
    {
        Schema::table(
            'files',
            static function (Blueprint $table) {
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'files',
            static function (Blueprint $table) {
                $table->dropSoftDeletes();
            }
        );
    }
}
