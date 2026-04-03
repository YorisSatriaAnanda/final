@php use Illuminate\Support\Str; @endphp

<x-app-layout>
    <div class="min-h-screen bg-[#f6f6f6]">
        <div class="flex">

            {{-- Sidebar --}}
            <aside class="w-72 min-h-screen bg-white shadow-xl rounded-r-[35px] p-6 hidden lg:block sticky top-0">
                <div class="flex items-center gap-3 mb-10">
                    <img src="{{ asset('images/logo.png') }}" class="w-12 h-12 object-contain" alt="Logo">
                    <div>
                        <h2 class="text-2xl font-bold text-red-700 uppercase leading-none">Mekarjaya</h2>
                        <p class="text-sm text-gray-500">Coffee Admin</p>
                    </div>
                </div>

                <nav class="space-y-3">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-red-700 text-white shadow-md">
                        <span>🏠</span>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl text-gray-700 hover:bg-red-50 hover:text-red-700 transition">
                        <span>📂</span>
                        <span class="font-medium">Kategori</span>
                    </a>

                    <a href="{{ route('menus.index') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl text-gray-700 hover:bg-red-50 hover:text-red-700 transition">
                        <span>☕</span>
                        <span class="font-medium">Menu</span>
                    </a>

                    <a href="{{ url('/') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl text-gray-700 hover:bg-red-50 hover:text-red-700 transition">
                        <span>🌐</span>
                        <span class="font-medium">Lihat Website</span>
                    </a>
                </nav>

                <div class="mt-12 bg-red-50 rounded-3xl p-5">
                    <h3 class="text-lg font-bold text-red-700 mb-2">Coffee Shop Panel</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Kelola kategori, menu, dan best seller dari satu dashboard yang simpel dan modern.
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-8">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gray-900 text-white py-3 rounded-2xl hover:bg-black transition">
                        Logout
                    </button>
                </form>
            </aside>

            {{-- Main Content --}}
            <main class="flex-1 p-6 lg:p-10">

                {{-- Mobile top --}}
                <div class="lg:hidden bg-white rounded-3xl p-4 shadow-md mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 object-contain" alt="Logo">
                        <div>
                            <h2 class="text-lg font-bold text-red-700 uppercase leading-none">Mekarjaya</h2>
                            <p class="text-xs text-gray-500">Coffee Admin</p>
                        </div>
                    </div>
                    <a href="{{ route('menus.index') }}"
                       class="bg-red-700 text-white px-4 py-2 rounded-xl text-sm">
                        Menu
                    </a>
                </div>

                {{-- Top Header --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">Welcome Back 👋</h1>
                        <p class="text-gray-500 mt-2">
                            Kelola data coffee shop kamu dengan tampilan modern.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('categories.create') }}"
                           class="bg-white border border-red-200 text-red-700 px-5 py-3 rounded-2xl hover:bg-red-50 transition shadow-sm">
                            + Kategori
                        </a>

                        <a href="{{ route('menus.create') }}"
                           class="bg-red-700 text-white px-5 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
                            + Menu
                        </a>
                    </div>
                </div>

                {{-- Statistik --}}
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
                                <a href="{{ route('categories.index') }}" class="text-red-700 font-semibold hover:underline">
                                    Lihat Semua
                                </a>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @forelse($categories as $category)
                                    <div class="bg-[#fafafa] border border-gray-100 rounded-3xl p-5 hover:shadow transition">
                                        <p class="text-sm text-gray-500 mb-2">Kategori</p>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $category->name }}</h3>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Belum ada kategori.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Menu terbaru --}}
                        <div class="bg-white rounded-[30px] p-6 shadow-md">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Menu Terbaru</h2>
                                <a href="{{ route('menus.index') }}" class="text-red-700 font-semibold hover:underline">
                                    Kelola Menu
                                </a>
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
                                        @forelse($latestMenus as $menu)
                                            <tr class="border-b last:border-0 hover:bg-red-50/40 transition">
                                                <td class="py-4">
                                                    <div class="flex items-center gap-4">
                                                        @if($menu->image)
                                                            <img src="{{ asset('storage/' . $menu->image) }}"
                                                                 class="w-14 h-14 object-cover rounded-2xl" alt="{{ $menu->name }}">
                                                        @else
                                                            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-xl">
                                                                ☕
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900">{{ $menu->name }}</h4>
                                                            <p class="text-sm text-gray-500">
                                                                {{ Str::limit($menu->description, 35) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4">{{ $menu->category->name }}</td>
                                                <td class="py-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
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
                                        @empty
                                            <tr>
                                                <td colspan="4" class="py-6 text-center text-gray-500">
                                                    Belum ada menu.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Kanan --}}
                    <div class="space-y-8">

                        {{-- Quick action --}}
                        <div class="bg-red-700 text-white rounded-[30px] p-6 shadow-md">
                            <h2 class="text-2xl font-bold mb-3">Quick Action</h2>
                            <p class="text-red-100 mb-6">
                                Tambahkan kategori atau menu baru dengan cepat.
                            </p>

                            <div class="space-y-3">
                                <a href="{{ route('categories.create') }}"
                                   class="block bg-white text-red-700 text-center py-3 rounded-2xl font-semibold hover:bg-red-50 transition">
                                    + Tambah Kategori
                                </a>

                                <a href="{{ route('menus.create') }}"
                                   class="block bg-red-800 text-white text-center py-3 rounded-2xl font-semibold hover:bg-red-900 transition">
                                    + Tambah Menu
                                </a>
                            </div>
                        </div>

                        {{-- Best seller --}}
                        <div class="bg-white rounded-[30px] p-6 shadow-md">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Best Seller</h2>
                                <span class="text-yellow-500 text-xl">★</span>
                            </div>

                            <div class="space-y-4">
                                @forelse($bestSellers as $item)
                                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#fafafa] hover:shadow transition">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                 class="w-16 h-16 rounded-2xl object-cover" alt="{{ $item->name }}">
                                        @else
                                            <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-xl">
                                                ☕
                                            </div>
                                        @endif

                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900">{{ $item->name }}</h3>
                                            <p class="text-sm text-gray-500">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <span class="text-yellow-500 text-xl">★</span>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Belum ada best seller.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="bg-white rounded-[30px] p-6 shadow-md">
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Info</h2>
                            <p class="text-gray-600 leading-relaxed">
                                Dashboard ini siap untuk mengelola
                                <span class="font-semibold text-red-700">kategori</span>,
                                <span class="font-semibold text-red-700">menu</span>,
                                dan
                                <span class="font-semibold text-red-700">best seller</span>.
                            </p>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>