@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Form Tambah Event</h2>

    <form action="{{ route('admin.events.store') }}" method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mt-2">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Judul Event</label>
            <input type="text" name="title"
                   class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Kategori Event</label>
            <select name="category_id"
                    class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Deskripsi Pendek</label>
            <textarea name="description"
                      class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200"
                      rows="3" required></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-4">
            <div>
                <label class="block mb-2 font-medium text-gray-700">Tanggal & Waktu</label>
                <input type="datetime-local" name="date"
                       class="w-full border border-gray-300 p-2.5 rounded" required>
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Harga Tiket (Rp)</label>
                <input type="number" name="price"
                       class="w-full border border-gray-300 p-2.5 rounded" required>
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Kapasitas Stok</label>
                <input type="number" name="stock"
                       class="w-full border border-gray-300 p-2.5 rounded" required>
            </div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-medium text-gray-700">Lokasi / Gedung</label>
            <input type="text" name="location"
                   class="w-full border border-gray-300 p-2.5 rounded" required>
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-medium text-gray-700">Poster Event (Opsional)</label>
            <input type="file" name="poster" id="poster" accept="image/*" 
                   class="w-full border border-gray-300 p-2.5 rounded @error('poster') border-red-500 @enderror">
            @error('poster')
                <p class="text-red-500 text-xs mt-1 font-medium">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end border-t pt-4">
            <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-2.5 rounded font-semibold hover:bg-indigo-700 shadow">
                Simpan Data
            </button>
        </div>
    </form>
</div>

{{-- Modal Popup Peringatan --}}
<div id="validationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 max-w-md w-full mx-4 overflow-hidden transform scale-95 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4 animate-bounce">
                <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2" id="modalTitle">Format File Tidak Valid</h3>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed" id="modalMessage">Hanya file dengan ekstensi JPEG, JPG, atau PNG yang diperbolehkan.</p>
            <button type="button" id="closeModalBtn" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-red-600 text-base font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                Mengerti
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const posterInput = document.getElementById('poster');
        const modal = document.getElementById('validationModal');
        const modalMessage = document.getElementById('modalMessage');
        const closeModalBtn = document.getElementById('closeModalBtn');

        function showValidationModal(message) {
            modalMessage.innerHTML = message;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Force reflow
            modal.offsetHeight;
            modal.firstElementChild.classList.remove('scale-95');
            modal.firstElementChild.classList.add('scale-100');
        }

        function hideValidationModal() {
            modal.firstElementChild.classList.remove('scale-100');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 150);
        }

        if (posterInput) {
            posterInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;

                const fileName = file.name;
                const fileExtension = fileName.split('.').pop().toLowerCase();
                const allowedExtensions = ['jpeg', 'jpg', 'png'];

                if (!allowedExtensions.includes(fileExtension)) {
                    showValidationModal('⚠️ File <strong>' + fileName + '</strong> tidak diizinkan.<br><br>Format file poster harus berupa <strong>JPEG, JPG, atau PNG</strong>.');
                    this.value = ''; // Reset input file
                }
            });
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', hideValidationModal);
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideValidationModal();
            }
        });
    });
</script>
@endsection
