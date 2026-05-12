@extends('layouts.admin')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Menu</h1>
        <p class="text-gray-500 mt-1">Tambahkan menu baru ke coffee shop kamu.</p>
    </div>



    <div class="bg-white rounded-[30px] shadow-md p-8 max-w-3xl">
        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                <select name="category_id"
                        class="w-full rounded-2xl border {{ $errors->has('category_id') ? 'border-red-500' : 'border-gray-200' }} px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Menu</label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Es Kopi Susu"
                       class="w-full rounded-2xl border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200' }} px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                @error('name')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Harga</label>
                    <input type="text"
                           name="price"
                           value="{{ old('price') }}"
                           placeholder="Contoh: 18.000"
                           class="w-full rupiah-input rounded-2xl border {{ $errors->has('price') ? 'border-red-500' : 'border-gray-200' }} px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    @error('price')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Stock</label>
                    <input type="number"
                           name="stock"
                           value="{{ old('stock', 0) }}"
                           min="0"
                           placeholder="Contoh: 20"
                           class="w-full rounded-2xl border {{ $errors->has('stock') ? 'border-red-500' : 'border-gray-200' }} px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    @error('stock')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Pengaturan Diskon</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tipe Diskon</label>
                        <select name="discount_type"
                                class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none bg-white">
                            <option value="">Tidak ada diskon</option>
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Persen (%)</option>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Potongan Harga (Rp)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Jumlah Diskon</label>
                        <input type="text"
                               name="discount_amount"
                               value="{{ old('discount_amount', 0) }}"
                               placeholder="0"
                               class="w-full rupiah-input rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none bg-white">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                <textarea name="description"
                          rows="4"
                          placeholder="Deskripsi menu..."
                          class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Gambar Menu</label>
                <input type="file"
                       name="image"
                       class="w-full rounded-2xl border border-gray-200 px-5 py-4 bg-white focus:ring-2 focus:ring-red-500 focus:outline-none">
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <label class="flex items-center gap-3 bg-[#fafafa] px-5 py-4 rounded-2xl border border-gray-100">
                    <input type="checkbox" name="is_best_seller" {{ old('is_best_seller') ? 'checked' : '' }}>
                    <span class="font-medium text-gray-700">Best Seller</span>
                </label>

                <label class="flex items-center gap-3 bg-[#fafafa] px-5 py-4 rounded-2xl border border-gray-100">
                    <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="font-medium text-gray-700">Aktif</span>
                </label>

                <label class="flex items-center gap-3 bg-[#fafafa] px-5 py-4 rounded-2xl border border-gray-100">
                    <input type="checkbox" name="is_available" {{ old('is_available', true) ? 'checked' : '' }}>
                    <span class="font-medium text-gray-700">Tersedia di Kasir</span>
                </label>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('menus.index') }}"
                   class="bg-gray-200 text-gray-800 px-6 py-3 rounded-2xl hover:bg-gray-300 transition">
                    Kembali
                </a>

                <button class="bg-red-700 text-white px-6 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
                    Simpan Menu
                </button>
            </div>
        </form>
    </div>

@endsection