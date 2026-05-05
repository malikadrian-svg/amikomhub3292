@extends('layouts.admin')

@section('title', 'Kelola Event')
@section('page-title', 'Manajemen Event')
@section('page-subtitle', 'Kelola semua data event yang tersedia.')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Manajemen Event</h2>
        <a href="{{ route('admin.events.create') }}"
           class="bg-indigo-700 text-white px-4 py-2 rounded hover:bg-indigo-800 transition">Tambah Event</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-5 border border-green-200">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex gap-6 items-start">

        {{-- Sidebar Kategori --}}
        <aside class="w-56 flex-shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 bg-indigo-50 border-b border-indigo-100">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-600">Filter Kategori</p>
                </div>
                <ul class="divide-y divide-gray-100">
                    <li>
                        <a href="{{ route('admin.events.index') }}"
                           class="flex justify-between items-center px-4 py-2.5 text-sm font-semibold transition
                                  {{ !$selectedCategory ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <span>Semua Event</span>
                            <span class="text-xs {{ !$selectedCategory ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }} px-2 py-0.5 rounded-full font-bold">
                                {{ $categories->sum('events_count') }}
                            </span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('admin.events.index', ['category_id' => $category->id]) }}"
                           class="flex justify-between items-center px-4 py-2.5 text-sm font-semibold transition
                                  {{ $selectedCategory == $category->id ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <span>{{ $category->name }}</span>
                            <span class="text-xs {{ $selectedCategory == $category->id ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }} px-2 py-0.5 rounded-full font-bold">
                                {{ $category->events_count }}
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Tabel Events --}}
        <div class="flex-1 min-w-0">
            <table class="w-full bg-white rounded-xl shadow-sm border border-gray-200 text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-300">
                        <th class="p-4 font-semibold text-gray-600">Judul Event</th>
                        <th class="p-4 font-semibold text-gray-600">Kategori</th>
                        <th class="p-4 font-semibold text-gray-600">Tanggal</th>
                        <th class="p-4 font-semibold text-gray-600">Aksi Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-4 text-indigo-600 font-medium">{{ $event->title }}</td>
                        <td class="p-4">
                            <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                {{ $event->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                        <td class="p-4 text-gray-600 flex gap-2">
                            <a href="{{ route('admin.events.edit', $event->id) }}"
                               class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1.5 rounded text-sm font-semibold hover:bg-blue-600 hover:text-white transition">
                                Edit Data
                            </a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                  onsubmit="return confirm('Anda yakin ingin menghapus data acara ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded text-sm font-semibold hover:bg-red-600 hover:text-white transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400 font-medium">
                            Tidak ada event di kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $events->links() }}
            </div>
        </div>

    </div>
@endsection
