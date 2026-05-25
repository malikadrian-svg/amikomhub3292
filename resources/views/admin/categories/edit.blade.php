@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Perbarui nama kategori yang sudah terdaftar.')

@section('content')
    <div class="max-w-2xl">

        {{-- Flash error validation --}}
        @if($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl px-6 py-4">
            <p class="font-bold mb-1">Periksa kembali inputan Anda:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

            {{-- Card Header --}}
            <div class="px-8 py-6 border-b bg-slate-50/50 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-slate-800 text-lg">{{ $category->name }}</h2>
                    <p class="text-xs text-slate-400">ID #{{ $category->id }} • Slug: <span class="font-mono text-indigo-500">{{ $category->slug }}</span></p>
                </div>
            </div>

            {{-- Form Body --}}
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="px-8 py-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Input: Nama Kategori --}}
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $category->name) }}"
                           placeholder="Contoh: Musik, Teknologi, Olahraga..."
                           class="w-full px-5 py-3 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-slate-800 placeholder-slate-400
                                  {{ $errors->has('name') ? 'border-rose-400 bg-rose-50' : '' }}">
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preview Slug --}}
                <div class="bg-slate-50 rounded-xl px-5 py-4 border border-slate-200">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Slug Baru (Preview)</p>
                    <p id="slug_preview" class="font-mono text-sm text-indigo-600">{{ $category->slug }}</p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                    <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                       class="px-6 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 active:scale-95 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('name').addEventListener('input', function () {
            const slug = this.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug_preview').textContent = slug || '—';
        });
    </script>
@endsection
