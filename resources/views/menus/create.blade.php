<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Tambah Menu</h1>

        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4">
            @csrf

            <select name="category_id" class="w-full border rounded p-3">
                <option value="">Pilih kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <input type="text" name="name" placeholder="Nama menu" class="w-full border rounded p-3">
            <input type="number" name="price" placeholder="Harga" class="w-full border rounded p-3">
            <textarea name="description" placeholder="Deskripsi" class="w-full border rounded p-3"></textarea>
            <input type="file" name="image" class="w-full border rounded p-3">

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_best_seller">
                Best Seller
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" checked>
                Aktif
            </label>

            <button class="bg-blue-600 text-white px-5 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>