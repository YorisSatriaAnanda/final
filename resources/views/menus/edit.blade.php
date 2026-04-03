<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Menu</h1>

        <form action="{{ route('menus.update', $menu) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4">
            @csrf
            @method('PUT')

            <select name="category_id" class="w-full border rounded p-3">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="name" value="{{ $menu->name }}" class="w-full border rounded p-3">
            <input type="number" name="price" value="{{ $menu->price }}" class="w-full border rounded p-3">
            <textarea name="description" class="w-full border rounded p-3">{{ $menu->description }}</textarea>
            <input type="file" name="image" class="w-full border rounded p-3">

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_best_seller" {{ $menu->is_best_seller ? 'checked' : '' }}>
                Best Seller
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" {{ $menu->is_active ? 'checked' : '' }}>
                Aktif
            </label>

            <button class="bg-yellow-500 text-white px-5 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>