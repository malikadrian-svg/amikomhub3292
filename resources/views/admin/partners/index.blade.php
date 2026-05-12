@extends('layouts.admin')

@section('title', 'Kelola Partner')
@section('page-title', 'Kelola Partner')
@section('page-subtitle', 'Daftar mitra dan sponsor yang bekerja sama.')

@section('content')
    {{-- Flash Message Sukses --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-2xl px-6 py-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

        {{-- Toolbar --}}
        <div class="px-8 py-6 bg-slate-50/50 border-b flex items-center gap-4">
            <form method="GET" action="{{ route('admin.partners.index') }}" class="flex flex-1 items-center gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                        </svg>
                    </span>
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari nama partner..."
                           autocomplete="off"
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-slate-800">
                </div>
                <button type="submit"
                        class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 active:scale-95 transition text-sm whitespace-nowrap">
                    Cari
                </button>
                @if($search)
                <a href="{{ route('admin.partners.index') }}"
                   class="px-4 py-3 bg-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-300 active:scale-95 transition text-sm whitespace-nowrap">
                    ✕ Reset
                </a>
                @endif
            </form>
            <span class="text-sm text-slate-500 font-medium whitespace-nowrap">
                @if($search)
                    Ditemukan: <strong class="text-indigo-600">{{ $partners->count() }}</strong> hasil
                @else
                    Total: <strong class="text-slate-800">{{ $partners->count() }}</strong> partner
                @endif
            </span>
            <a href="{{ route('admin.partners.create') }}"
               class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition whitespace-nowrap text-sm">
                + Tambah Partner
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-16">No</th>
                        <th class="px-8 py-4">Logo</th>
                        <th class="px-8 py-4">Partner</th>
                        <th class="px-8 py-4">URL Logo</th>
                        <th class="px-8 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @foreach($partners as $partner)
                    <tr class="hover:bg-slate-50/50 transition">

                        {{-- No --}}
                        <td class="px-8 py-6 font-bold text-slate-400">{{ $loop->iteration }}</td>

                        {{-- Logo (mengikuti style kolom Poster di events) --}}
                        <td class="px-8 py-6">
                            <img src="{{ $partner->logo_url }}"
                                 alt="Logo {{ $partner->name }}"
                                 class="w-16 h-16 rounded-xl object-contain shadow-sm bg-slate-50 p-1 border border-slate-100">
                        </td>

                        {{-- Nama Partner + ID (mengikuti style kolom Event di events) --}}
                        <td class="px-8 py-6">
                            <p class="font-black text-slate-800">{{ $partner->name }}</p>
                            <p class="text-xs text-slate-400">ID #{{ $partner->id }} • Ditambah {{ $partner->created_at->format('d M Y') }}</p>
                        </td>

                        {{-- URL Logo --}}
                        <td class="px-8 py-6">
                            <a href="{{ $partner->logo_url }}"
                               target="_blank"
                               class="text-indigo-500 hover:text-indigo-700 text-xs font-mono underline underline-offset-2 transition block max-w-[220px] truncate">
                                {{ $partner->logo_url }}
                            </a>
                        </td>

                        {{-- Aksi (tombol Edit & Hapus, sama persis seperti events) --}}
                        <td class="px-8 py-6">
                            <div class="flex gap-2">
                                <button class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                    @if($partners->isEmpty())
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center">
                            @if($search)
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                                    </svg>
                                    <p class="font-bold text-slate-500">Partner tidak ditemukan</p>
                                    <p class="text-slate-400 text-sm">
                                        Tidak ada partner dengan nama
                                        <span class="font-semibold text-indigo-500">"{{ $search }}"</span>
                                    </p>
                                    <a href="{{ route('admin.partners.index') }}"
                                       class="mt-1 px-5 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">
                                        Tampilkan semua partner
                                    </a>
                                </div>
                            @else
                                <p class="text-slate-400 font-medium">Belum ada data partner.</p>
                            @endif
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
@endsection
