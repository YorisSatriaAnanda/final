<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Kategori</h1>
            <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah</a>
        </div>

        <table class="w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr class="border-t">
                        <td class="p-4">{{ $loop->iteration }}</td>
                        <td class="p-4">{{ $category->name }}</td>
                        <td class="p-4 flex gap-2">
                            <a href="{{ route('categories.edit', $category) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>