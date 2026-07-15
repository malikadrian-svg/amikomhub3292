<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('event')->latest()->paginate(15);

        return view('admin.transactions', compact('transactions'));
    }

    /**
     * Tandai transaksi sebagai sukses secara manual (bypass webhook).
     * Berguna saat development lokal dimana webhook Midtrans tidak bisa masuk.
     */
    public function markSuccess(Transaction $transaction)
    {
        $result = $transaction->markAsSuccess();

        if ($result) {
            return back()->with('success', 'Transaksi #' . $transaction->order_id . ' berhasil ditandai sebagai Sukses dan E-Ticket telah dikirim ke ' . $transaction->customer_email . '.');
        }

        return back()->with('info', 'Transaksi ini sudah berstatus sukses sebelumnya, tidak ada perubahan.');
    }
}