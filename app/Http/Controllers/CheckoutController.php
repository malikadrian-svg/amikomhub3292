<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'event_id'       => 'required|exists:events,id',
        ]);

        // Generate order ID unik
        $orderId = 'TRX-' . strtoupper(uniqid());

        // Ambil event untuk hitung harga
        $event = \App\Models\Event::findOrFail($data['event_id']);
        $serviceFee = 5000;
        $totalPrice  = $event->price + $serviceFee;

        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'total_price'    => $totalPrice,
            'status'         => 'Success', // simulasi langsung success
        ]);

        // Simpan ke session untuk ditampilkan di halaman tiket
        session([
            'ticket_order_id'      => $transaction->order_id,
            'ticket_customer_name' => $transaction->customer_name,
            'ticket_event_title'   => $event->title,
            'ticket_event_date'    => $event->date,
            'ticket_event_location'=> $event->location,
            'ticket_total_price'   => $totalPrice,
        ]);

        return redirect()->route('ticket');
    }
}
