@extends('layouts.admin')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Menu</h1>
        <p class="text-gray-500 mt-1">Perbarui data menu coffee shop kamu.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-100 text-red-700 px-5 py-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[30px] shadow-md p-8 max-w-3xl">
        <form action="{{ route('menus.update', $menu) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                <select name="category_id"
                        class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Menu</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $menu->name) }}"
                       placeholder="Contoh: Es Kopi Susu"
                       class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Harga</label>
                    <input type="text"
                           name="price"
                           value="{{ old('price', $menu->price) }}"
                           placeholder="Contoh: 18.000"
                           class="w-full rupiah-input rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Stock</label>
                    <input type="number"
                           name="stock"
                           value="{{ old('stock', $menu->stock) }}"
                           min="0"
                           placeholder="Contoh: 20"
                           class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
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
                            <option value="percent" {{ old('discount_type', $menu->discount_type) == 'percent' ? 'selected' : '' }}>Persen (%)</option>
                            <option value="fixed" {{ old('discount_type', $menu->discount_type) == 'fixed' ? 'selected' : '' }}>Potongan Harga (Rp)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Jumlah Diskon</label>
                        <input type="text"
                               name="discount_amount"
                               value="{{ old('discount_amount', $menu->discount_amount ?: 0) }}"
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
                          class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">{{ old('description', $menu->description) }}</textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Gambar Menu</label>
                <input type="file"
                       name="image"
                       class="w-full rounded-2xl border border-gray-200 px-5 py-4 bg-white focus:ring-2 focus:ring-red-500 focus:outline-none">

                @if($menu->image)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Gambar Saat Ini:</p>
                        <img src="{{ asset('storage/' . $menu->image) }}"
                             class="w-28 h-28 object-cover rounded-2xl shadow">
                    </div>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <label class="flex items-center gap-3 bg-[#fafafa] px-5 py-4 rounded-2xl border border-gray-100">
                    <input type="checkbox" name="is_best_seller" {{ old('is_best_seller', $menu->is_best_seller) ? 'checked' : '' }}>
                    <span class="font-medium text-gray-700">Best Seller</span>
                </label>

                <label class="flex items-center gap-3 bg-[#fafafa] px-5 py-4 rounded-2xl border border-gray-100">
                    <input type="checkbox" name="is_active" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                    <span class="font-medium text-gray-700">Aktif</span>
                </label>

                <label class="flex items-center gap-3 bg-[#fafafa] px-5 py-4 rounded-2xl border border-gray-100">
                    <input type="checkbox" name="is_available" {{ old('is_available', $menu->is_available) ? 'checked' : '' }}>
                    <span class="font-medium text-gray-700">Tersedia di Kasir</span>
                </label>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('menus.index') }}"
                   class="bg-gray-200 text-gray-800 px-6 py-3 rounded-2xl hover:bg-gray-300 transition">
                    Kembali
                </a>

                <button class="bg-red-700 text-white px-6 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
                    Update Menu
                </button>
            </div>
        </form>
    </div>

@endsection