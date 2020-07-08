<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexForWillBeDeletedAtColumnInFilesTable extends Migration
{
    public function up(): void
    {
        Schema::table('files', static function (Blueprint $table) {
            $table->index('will_be_deleted_at', 'idx_files_will_be_deleted_at');
        });
    }

    public function down(): void
    {
        Schema::table('files', static function (Blueprint $table) {
            $table->dropIndex('idx_files_will_be_deleted_at');
        });
    }
}
