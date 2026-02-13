<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoanAndReturnDateToLoansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->date('loan_date')->nullable()->after('id');
            $table->date('return_date')->nullable()->after('loan_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['loan_date', 'return_date']);
        });
    }
}
