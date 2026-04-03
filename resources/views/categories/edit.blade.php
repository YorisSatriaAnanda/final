<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Kategori</h1>

        <form action="{{ route('categories.update', $category) }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ $category->name }}" class="w-full border rounded p-3">
            <button class="bg-yellow-500 text-white px-5 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>