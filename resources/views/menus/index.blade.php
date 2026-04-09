@extends('layouts.admin')

@section('content')

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Data Menu</h1>
            <p class="text-gray-500 mt-1">Kelola semua menu coffee shop kamu.</p>
        </div>

        <a href="{{ route('menus.create') }}"
           class="bg-red-700 text-white px-5 py-3 rounded-2xl hover:bg-red-800 transition shadow-md flex items-center gap-2">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Menu
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[30px] shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Daftar Menu</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#fafafa]">
                    <tr class="text-left text-gray-500">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Nama Menu</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Best Seller</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr class="border-t hover:bg-red-50/30 transition">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>

                            <td class="px-6 py-4">
                                @if($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}"
                                         class="w-16 h-16 object-cover rounded-2xl shadow-sm">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-red-700">
                                        <i data-lucide="coffee" class="w-8 h-8"></i>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $menu->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($menu->description, 40) }}</p>
                                </div>
                            </td>

                            <td class="px-6 py-4">{{ $menu->category->name }}</td>
                            <td class="px-6 py-4 font-semibold">
                                @if($menu->discount_amount > 0)
                                    <span class="text-xs line-through text-red-400 block font-normal">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                @endif
                                Rp {{ number_format($menu->final_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-semibold">{{ $menu->stock }}</td>

                            <td class="px-6 py-4">
                                @if($menu->is_best_seller)
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                        <i data-lucide="thumbs-up" class="w-3 h-3 fill-current"></i>
                                        BEST
                                    </span>
                                @else
                                    <span class="text-gray-300">
                                        <i data-lucide="minus" class="w-4 h-4"></i>
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($menu->is_active && $menu->is_available)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Aktif
                                    </span>
                                @else
                                    <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('menus.edit', $menu) }}"
                                       class="bg-yellow-500 text-white px-4 py-2 rounded-xl hover:bg-yellow-600 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('menus.destroy', $menu) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                Belum ada menu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection