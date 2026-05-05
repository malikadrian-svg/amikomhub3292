@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')
@section('page-subtitle', 'Manajemen kategori event yang tersedia.')

@section('content')
    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 border border-green-200 font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Categories Table --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b flex justify-between items-center">
            <h3 class="font-black text-xl">Daftar Kategori</h3>
            <span class="text-slate-400 text-sm font-medium">{{ $categories->count() }} Kategori</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">#</th>
                        <th class="px-8 py-4">Nama Kategori</th>
                        <th class="px-8 py-4">Slug</th>
                        <th class="px-8 py-4">Jumlah Event</th>
                        <th class="px-8 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($categories as $index => $category)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-8 py-6 text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="px-8 py-6">
                                <p class="font-bold uppercase tracking-wide text-sm">{{ $category->name }}</p>
                            </td>
                            <td class="px-8 py-6 font-medium text-slate-600">{{ $category->slug }}</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold">
                                    {{ $category->events_count }} Event
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="px-4 py-1.5 bg-amber-50 text-amber-600 rounded-lg font-bold text-xs hover:bg-amber-600 hover:text-white transition">Edit</button>
                                    <button class="px-4 py-1.5 bg-red-50 text-red-600 rounded-lg font-bold text-xs hover:bg-red-600 hover:text-white transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium">
                                Belum ada kategori yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection