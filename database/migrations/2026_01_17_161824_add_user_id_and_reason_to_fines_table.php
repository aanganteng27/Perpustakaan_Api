<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fines', function (Blueprint $table) {

            // 🔥 relasi ke user (pemilik denda)
            $table->foreignId('user_id')
                ->after('loan_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // 🔥 alasan denda (buku hilang, rusak, dll)
            $table->string('reason')
                ->nullable()
                ->after('amount');
        });
    }

    public function down()
    {
        Schema::table('fines', function (Blueprint $table) {

            // hapus foreign key dulu
            $table->dropForeign(['user_id']);

            // hapus kolom
            $table->dropColumn(['user_id', 'reason']);
        });
    }
};
