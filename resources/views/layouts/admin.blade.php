<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mekarjaya Coffee</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#f6f6f6] text-gray-900 font-sans antialiased">

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
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-red-700 text-white shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-700' }} transition">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->routeIs('categories.*') ? 'bg-red-700 text-white shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-700' }} transition">
                        <i data-lucide="folder" class="w-5 h-5"></i>
                        <span class="font-medium">Kategori</span>
                    </a>

                    <a href="{{ route('menus.index') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->routeIs('menus.*') ? 'bg-red-700 text-white shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-700' }} transition">
                        <i data-lucide="coffee" class="w-5 h-5"></i>
                        <span class="font-medium">Menu</span>
                    </a>

                    {{-- Menu Kasir --}}
                    <a href="{{ route('cashier.index') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->routeIs('cashier.*') ? 'bg-red-700 text-white shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-700' }} transition">
                        <i data-lucide="receipt" class="w-5 h-5"></i>
                        <span class="font-medium">Kasir</span>
                    </a>

                    {{-- Menu Transaksi (History) --}}
                    <a href="{{ route('orders.index') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->routeIs('orders.*') ? 'bg-red-700 text-white shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-700' }} transition">
                        <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                        <span class="font-medium">Transaksi</span>
                    </a>

                    {{-- Menu Laporan --}}
                    <a href="{{ route('reports.index') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->routeIs('reports.*') ? 'bg-red-700 text-white shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-700' }} transition">
                        <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                        <span class="font-medium">Laporan</span>
                    </a>

                    {{-- Menu Ulasan --}}
                    <a href="{{ route('admin.reviews.index') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->routeIs('admin.reviews.*') ? 'bg-red-700 text-white shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-700' }} transition">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                        <span class="font-medium">Ulasan</span>
                    </a>

                    <a href="{{ url('/') }}"
                       class="flex items-center gap-3 px-5 py-4 rounded-2xl text-gray-700 hover:bg-red-50 hover:text-red-700 transition">
                        <i data-lucide="globe" class="w-5 h-5"></i>
                        <span class="font-medium">Lihat Website</span>
                    </a>
                </nav>

                <form method="POST" action="{{ route('logout') }}" class="mt-10">
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
                    <div class="flex gap-2">
                        <a href="{{ route('orders.index') }}"
                           class="bg-gray-100 text-gray-700 px-3 py-2 rounded-xl text-sm border border-gray-200">
                            <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                        </a>
                        <a href="{{ route('cashier.index') }}"
                           class="bg-red-700 text-white px-4 py-2 rounded-xl text-sm">
                            Kasir
                        </a>
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>