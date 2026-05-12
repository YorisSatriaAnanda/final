@extends('layouts.admin')

@section('content')

    {{-- Top Header --}}
    <div class="mb-10">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 flex items-center gap-3">
                Welcome Back 
                <i data-lucide="sparkles" class="w-8 h-8 text-yellow-500"></i>
            </h1>
            <p class="text-gray-500 mt-2">
                Kelola data coffee shop kamu dengan tampilan modern.
            </p>
        </div>
    </div>

    {{-- Statistik Harian (Data dari ChatGPT) --}}
    @if($isAdminOrOwner)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-[28px] p-6 shadow-md border-l-8 border-red-700">
            <p class="text-gray-500 mb-2 font-medium">Transaksi Hari Ini</p>
            <h2 class="text-4xl font-bold text-gray-900">{{ $todayTransactions }}</h2>
        </div>

        <div class="bg-white rounded-[28px] p-6 shadow-md border-l-8 border-green-600">
            <p class="text-gray-500 mb-2 font-medium">Omset Hari Ini</p>
            <h2 class="text-3xl font-bold text-gray-900">
                Rp {{ number_format($todayRevenue, 0, ',', '.') }}
            </h2>
        </div>
    </div>
    @endif

    {{-- Statistik Inventori (Data dari VS Code) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-[28px] p-6 shadow-md">
            <p class="text-gray-500 mb-2">Total Kategori</p>
            <h2 class="text-4xl font-bold text-red-700">{{ $totalCategories }}</h2>
        </div>

        <div class="bg-white rounded-[28px] p-6 shadow-md">
            <p class="text-gray-500 mb-2">Total Menu</p>
            <h2 class="text-4xl font-bold text-red-700">{{ $totalMenus }}</h2>
        </div>

        <div class="bg-white rounded-[28px] p-6 shadow-md">
            <p class="text-gray-500 mb-2">Best Seller</p>
            <h2 class="text-4xl font-bold text-red-700">{{ $totalBestSeller }}</h2>
        </div>

        <div class="bg-white rounded-[28px] p-6 shadow-md">
            <p class="text-gray-500 mb-2">Menu Aktif</p>
            <h2 class="text-4xl font-bold text-red-700">{{ $totalActiveMenus }}</h2>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- Kiri --}}
        <div class="xl:col-span-2 space-y-8">

            {{-- Kategori --}}
            <div class="bg-white rounded-[30px] p-6 shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Kategori Menu</h2>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('categories.index') }}" class="text-red-700 font-semibold hover:underline">
                        Lihat Semua
                    </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @if(count($categories ?? []) > 0)
                        @foreach($categories as $category)
                            <div class="bg-[#fafafa] border border-gray-100 rounded-3xl p-5 hover:shadow transition">
                                <p class="text-sm text-gray-500 mb-2">Kategori</p>
                                <h3 class="text-xl font-bold text-gray-900">{{ $category->name }}</h3>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 col-span-full text-center py-4">Belum ada kategori.</p>
                    @endif
                </div>
            </div>

            {{-- Menu terbaru --}}
            <div class="bg-white rounded-[30px] p-6 shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Menu Terbaru</h2>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('menus.index') }}" class="text-red-700 font-semibold hover:underline">
                        Kelola Menu
                    </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-3">Menu</th>
                                <th class="py-3">Kategori</th>
                                <th class="py-3">Harga</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($latestMenus ?? []) > 0)
                                @foreach($latestMenus as $menu)
                                    <tr class="border-b last:border-0 hover:bg-red-50/40 transition">
                                        <td class="py-4">
                                            <div class="flex items-center gap-4">
                                                @if($menu->image)
                                                    <img src="{{ asset('storage/' . $menu->image) }}"
                                                         class="w-14 h-14 object-cover rounded-2xl" alt="{{ $menu->name }}">
                                                @else
                                                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center text-red-700">
                                                        <i data-lucide="coffee" class="w-7 h-7"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">{{ $menu->name }}</h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ \Illuminate\Support\Str::limit($menu->description, 35) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-gray-700">{{ $menu->category->name }}</td>
                                        <td class="py-4 font-medium">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                        <td class="py-4">
                                            @if($menu->is_active)
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-500">
                                        Belum ada menu.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kanan --}}
        <div class="space-y-8">

            @if(auth()->user()->role === 'admin')
            {{-- Quick action --}}
            <div class="bg-red-700 text-white rounded-[30px] p-6 shadow-md">
                <h2 class="text-2xl font-bold mb-3">Quick Action</h2>
                <p class="text-red-100 mb-6 text-sm">
                    Tambahkan kategori atau menu baru dengan cepat untuk memperbarui katalog tokomu.
                </p>

                <div class="space-y-3">
                    <a href="{{ route('categories.create') }}"
                       class="block bg-white text-red-700 text-center py-3 rounded-2xl font-bold hover:bg-red-50 transition shadow-sm flex items-center justify-center gap-2">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Tambah Kategori
                    </a>

                    <a href="{{ route('menus.create') }}"
                       class="block bg-red-800 text-white text-center py-3 rounded-2xl font-bold hover:bg-red-900 transition border border-red-600 flex items-center justify-center gap-2">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Tambah Menu
                    </a>
                </div>
            </div>
            @endif

            {{-- Best seller --}}
            <div class="bg-white rounded-[30px] p-6 shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Best Seller</h2>
                    <i data-lucide="star" class="w-6 h-6 text-yellow-500 fill-current"></i>
                </div>

                <div class="space-y-4">
                    @if(count($bestSellers ?? []) > 0)
                        @foreach($bestSellers as $item)
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#fafafa] hover:shadow-sm transition border border-transparent hover:border-red-100">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                         class="w-16 h-16 rounded-2xl object-cover" alt="{{ $item->name }}">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center text-red-700">
                                        <i data-lucide="coffee" class="w-8 h-8"></i>
                                    </div>
                                @endif
    
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900">{{ $item->name }}</h3>
                                    <p class="text-sm text-gray-700">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
    
                                <span class="text-yellow-500 text-lg font-bold">#{{ $loop->iteration }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center py-2">Belum ada best seller.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection