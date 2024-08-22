<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rent;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use PDF; // Import the PDF facade

class TransactionController extends Controller
{
    public function product()
    {
        $transactions = Transaction::with('details.product')->latest()->paginate(10);
        $grandQuantity = TransactionDetail::sum('quantity');

        return view('admin.transaction.product', compact('transactions', 'grandQuantity'));
    }

    public function vehicle()
    {
        $rents = Rent::with('vehicle', 'user')->when(request()->q, function ($search) {
            $search = $search->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . request()->q . '%');
            })->orWhereHas('vehicle', function ($query) {
                $query->where('name', 'like', '%' . request()->q . '%');
            });
        })->latest()->paginate(10);

        return view('admin.transaction.vehicle', compact('rents'));
    }

    // Method to export transactions to PDF
    public function exportPDF()
    {
        $transactions = Transaction::with('details.product.category', 'user')->get();
        $grandQuantity = $transactions->sum(function ($transaction) {
            return $transaction->details->sum('quantity');
        });

        $pdf = PDF::loadView('admin.transaction.pdf', compact('transactions', 'grandQuantity'));

        return $pdf->download('report-daftarBarangKeluar.pdf');
    }
}
