@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')
@section('page-subtitle', 'Manajemen kategori event yang tersedia.')

@section('content')
    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-2xl px-6 py-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Categories Table --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

        {{-- Toolbar: Search + Tambah --}}
        <div class="px-8 py-6 bg-slate-50/50 border-b flex items-center gap-4">
            {{-- Form Search --}}
            <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-1 items-center gap-3">
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
                           placeholder="Cari nama kategori..."
                           autocomplete="off"
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-slate-800">
                </div>
                <button type="submit"
                        class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 active:scale-95 transition text-sm whitespace-nowrap">
                    Cari
                </button>
                @if($search)
                <a href="{{ route('admin.categories.index') }}"
                   class="px-4 py-3 bg-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-300 active:scale-95 transition text-sm whitespace-nowrap">
                    ✕ Reset
                </a>
                @endif
            </form>

            {{-- Info Jumlah + Tombol Tambah --}}
            <span class="text-sm text-slate-500 font-medium whitespace-nowrap">
                @if($search)
                    Ditemukan: <strong class="text-indigo-600">{{ $categories->count() }}</strong> hasil
                @else
                    Total: <strong class="text-slate-800">{{ $categories->count() }}</strong> kategori
                @endif
            </span>
            <a href="{{ route('admin.categories.create') }}"
               class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition whitespace-nowrap text-sm">
                + Tambah Kategori
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-16">No</th>
                        <th class="px-8 py-4">Nama Kategori</th>
                        <th class="px-8 py-4">Slug</th>
                        <th class="px-8 py-4">Jumlah Event</th>
                        <th class="px-8 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 font-bold text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-8 py-6">
                                <p class="font-black text-slate-800 uppercase tracking-wide text-sm">{{ $category->name }}</p>
                            </td>
                            <td class="px-8 py-6 font-medium text-slate-500 font-mono text-sm">{{ $category->slug }}</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold">
                                    {{ $category->events_count }} Event
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition"
                                       title="Edit Kategori">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    {{-- Form Hapus --}}
                                    <form action="{{ route('admin.categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori {{ addslashes($category->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                                title="Hapus Kategori">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                @if($search)
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                                        </svg>
                                        <p class="font-bold text-slate-500">Kategori tidak ditemukan</p>
                                        <p class="text-slate-400 text-sm">
                                            Tidak ada kategori dengan nama
                                            <span class="font-semibold text-indigo-500">"{{ $search }}"</span>
                                        </p>
                                        <a href="{{ route('admin.categories.index') }}"
                                           class="mt-1 px-5 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">
                                            Tampilkan semua kategori
                                        </a>
                                    </div>
                                @else
                                    <p class="text-slate-400 font-medium">Belum ada kategori yang tersedia.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection