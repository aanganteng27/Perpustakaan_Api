<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinesTable extends Migration
{
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['belum_dibayar', 'sudah_dibayar'])->default('belum_dibayar');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fines');
    }
}
