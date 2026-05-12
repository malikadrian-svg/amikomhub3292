@extends('layouts.admin')

@section('title', 'Tambah Partner Baru')
@section('page-title', 'Tambah Partner Baru')
@section('page-subtitle', 'Isi form di bawah untuk mendaftarkan mitra baru.')

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
            <div class="px-8 py-6 border-b bg-slate-50/50">
                <h2 class="font-black text-slate-800 text-lg">Formulir Partner</h2>
                <p class="text-sm text-slate-500 mt-1">Kolom bertanda <span class="text-rose-500 font-bold">*</span> wajib diisi.</p>
            </div>

            {{-- Form Body --}}
            <form action="{{ route('admin.partners.store') }}" method="POST" class="px-8 py-8 space-y-6">
                @csrf

                {{-- Input: Nama Partner --}}
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">
                        Nama Partner <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Contoh: PT. Amikom Teknologi"
                           class="w-full px-5 py-3 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-slate-800 placeholder-slate-400
                                  {{ $errors->has('name') ? 'border-rose-400 bg-rose-50' : '' }}">
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input: Logo URL --}}
                <div>
                    <label for="logo_url" class="block text-sm font-bold text-slate-700 mb-2">
                        URL Logo <span class="text-rose-500">*</span>
                    </label>

                    {{-- Pilihan cepat (dropdown preset) --}}
                    <select id="logo_preset"
                            onchange="document.getElementById('logo_url').value = this.value; updatePreview(this.value)"
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 bg-white outline-none text-slate-600 mb-3">
                        <option value="">— Pilih URL Placeholder Cepat —</option>
                        <option value="https://placehold.co/200x200?text=Partner+1">placehold.co 200x200 – Partner 1</option>
                        <option value="https://placehold.co/200x200?text=Partner+2">placehold.co 200x200 – Partner 2</option>
                        <option value="https://placehold.co/200x200?text=Logo">placehold.co 200x200 – Logo</option>
                        <option value="https://placehold.co/200x200/6366f1/ffffff?text=AH">placehold.co 200x200 – Biru (AH)</option>
                        <option value="https://ui-avatars.com/api/?name=Partner&background=6366f1&color=fff&size=200">ui-avatars.com – Auto Initial</option>
                    </select>

                    <input type="url"
                           id="logo_url"
                           name="logo_url"
                           value="{{ old('logo_url', 'https://placehold.co/200x200') }}"
                           placeholder="https://placehold.co/200x200"
                           oninput="updatePreview(this.value)"
                           class="w-full px-5 py-3 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-slate-800 font-mono text-sm
                                  {{ $errors->has('logo_url') ? 'border-rose-400 bg-rose-50' : '' }}">
                    @error('logo_url')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror

                    {{-- Preview Logo --}}
                    <div class="mt-4 flex items-center gap-4">
                        <img id="logo_preview"
                             src="{{ old('logo_url', 'https://placehold.co/200x200') }}"
                             alt="Preview Logo"
                             class="w-20 h-20 rounded-2xl object-contain border border-slate-200 bg-slate-50 p-1 shadow-sm">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Preview Logo</p>
                            <p class="text-xs text-slate-400 mt-0.5">Gambar akan muncul otomatis saat URL diubah.</p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                    <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
                        Simpan Partner
                    </button>
                    <a href="{{ route('admin.partners.index') }}"
                       class="px-6 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 active:scale-95 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updatePreview(url) {
            const img = document.getElementById('logo_preview');
            if (url) img.src = url;
        }
    </script>
@endsection
