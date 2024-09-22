<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF; // Import the PDF facade
// use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->from;
        $toDate = $request->to;

        $transactions = Transaction::with('details', 'user')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        return view('admin.report.index', compact('transactions', 'fromDate', 'toDate'));
    }

    // Method to export transactions to PDF
    public function exportPDF(Request $request)
    {
        $fromDate = $request->from;
        $toDate = $request->to;

        $transactions = Transaction::with('details', 'user')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        $pdf = PDF::loadView('admin.report.pdf', compact('transactions', 'fromDate', 'toDate'));

        return $pdf->download('reportDataBarang.pdf');
    }
}
