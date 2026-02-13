<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Matikan sementara check strict agar tidak error truncated
        DB::statement('SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=""');

        Schema::table('loans', function (Blueprint $table) {
            // Kita ubah dulu ke text/string biasa supaya aman dari error ENUM
            $table->string('status')->default('pending')->change();
            
            // Buat tanggal jadi nullable
            $table->date('borrowed_at')->nullable()->change();
            $table->date('due_date')->nullable()->change();
        });

        // Setelah berhasil jadi string, kita kembalikan ke ENUM yang baru
        Schema::table('loans', function (Blueprint $table) {
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'hilang', 'ditolak'])
                  ->default('pending')
                  ->change();
        });

        DB::statement('SET SQL_MODE=@OLD_SQL_MODE');
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->date('borrowed_at')->nullable(false)->change();
            $table->date('due_date')->nullable(false)->change();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'hilang'])
                  ->default('dipinjam')
                  ->change();
        });
    }
};