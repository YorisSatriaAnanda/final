<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Tambah Kategori</h1>

        <form action="{{ route('categories.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori" class="w-full border rounded p-3">
            <button class="bg-blue-600 text-white px-5 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>