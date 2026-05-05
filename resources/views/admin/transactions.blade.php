@extends('layouts.admin')

@section('title', 'Laporan Transaksi')
@section('page-title', 'Laporan Transaksi')
@section('page-subtitle', 'Pantau arus kas dan penjualan tiket Anda.')

@section('content')
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">Order ID</th>
                        <th class="px-8 py-4">Detail Pembeli</th>
                        <th class="px-8 py-4">Event</th>
                        <th class="px-8 py-4">Tgl Transaksi</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Total Tagihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6">
                            <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg text-sm">
                                #{{ $trx->order_id }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-bold text-slate-800">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-500">{{ $trx->customer_email }}</p>
                            <p class="text-xs text-slate-400">{{ $trx->customer_phone }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-medium text-slate-700">{{ $trx->event->title ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-6 text-sm text-slate-500">
                            {{ $trx->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-8 py-6">
                            @if($trx->status === 'Success')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Success</span>
                            @elseif($trx->status === 'Pending')
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase ring-1 ring-orange-200">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase ring-1 ring-slate-200">{{ $trx->status }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right font-black text-slate-900">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-16 text-center text-slate-400 font-medium">
                            Belum ada transaksi masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($transactions->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t flex justify-between items-center">
            <p class="text-sm text-slate-500 font-medium">
                Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi
            </p>
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
@endsection