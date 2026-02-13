<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Fine;

class DashboardController extends Controller
{
    public function statistics()
    {
        $totalBooks = Book::count();
        $totalLoans = Loan::count();
        $totalFines = Fine::sum('amount');

        return response()->json([
            'total_books' => $totalBooks,
            'total_loans' => $totalLoans,
            'total_fines' => $totalFines,
        ]);
    }
}
