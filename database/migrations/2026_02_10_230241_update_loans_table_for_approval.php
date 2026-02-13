<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // SQLite tidak mendukung perubahan banyak kolom sekaligus dengan change()
            // Jadi kita buat satu per satu atau pastikan doctrine/dbal terinstall
            $table->string('status')->default('pending')->change();
            $table->date('borrowed_at')->nullable()->change();
            $table->date('due_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->string('status')->default('dipinjam')->change();
            $table->date('borrowed_at')->nullable(false)->change();
            $table->date('due_date')->nullable(false)->change();
        });
    }
};