<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Menu</h1>
            <a href="{{ route('menus.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah</a>
        </div>

        <table class="w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Gambar</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Harga</th>
                    <th class="p-4 text-left">Best Seller</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                    <tr class="border-t">
                        <td class="p-4">{{ $loop->iteration }}</td>
                        <td class="p-4">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-16 h-16 object-cover rounded">
                            @endif
                        </td>
                        <td class="p-4">{{ $menu->name }}</td>
                        <td class="p-4">{{ $menu->category->name }}</td>
                        <td class="p-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td class="p-4">{{ $menu->is_best_seller ? 'Ya' : 'Tidak' }}</td>
                        <td class="p-4 flex gap-2">
                            <a href="{{ route('menus.edit', $menu) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{ route('menus.destroy', $menu) }}" method="POST">
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