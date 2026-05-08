<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mekarjaya Coffee</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}" />
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#f6f6f6] text-gray-900 font-sans antialiased">

    <div class="min-h-screen bg-[#f6f6f6]">
        <div class="flex">

            {{-- Sidebar --}}
            <aside id="main-sidebar" class="w-72 min-h-screen bg-white shadow-xl rounded-r-[35px] p-6 hidden lg:block sticky top-0 transition-all duration-300 overflow-hidden">
                <div class="flex items-center gap-3 mb-10">
                    <img src="{{ asset('images/logo.png') }}" class="w-14 h-14 object-contain" alt="Logo">
                    <div>
                        <h2 class="text-2xl font-black text-[#DA291C] uppercase leading-none tracking-tight font-poppins">Mekarjaya</h2>
                        <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest font-semibold text-[10px]">Coffee Admin</p>
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
            <main class="flex-1 p-6 lg:p-10 transition-all duration-300">

                {{-- Mobile top --}}
                <div class="lg:hidden bg-white rounded-3xl p-4 shadow-md mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="w-12 h-12 object-contain" alt="Logo">
                        <div>
                            <h2 class="text-lg font-black text-[#DA291C] uppercase leading-none font-poppins">Mekarjaya</h2>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Coffee Admin</p>
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

        // Sidebar Toggle Logic
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('main-sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');

            if (sidebar && toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    // Gunakan inline style dengan !important untuk mengoverride class Tailwind 'lg:block'
                    if (window.getComputedStyle(sidebar).display === 'none') {
                        sidebar.style.setProperty('display', 'block', 'important');
                    } else {
                        sidebar.style.setProperty('display', 'none', 'important');
                    }
                });
            }

            // --- Logika Format Rupiah Otomatis ---
            const rupiahInputs = document.querySelectorAll('.rupiah-input');
            
            rupiahInputs.forEach(input => {
                // Format saat inisialisasi (jika ada nilai awal)
                if (input.value) {
                    input.value = formatRupiah(input.value);
                }

                input.addEventListener('input', function(e) {
                    this.value = formatRupiah(this.value);
                });
            });

            function formatRupiah(angka) {
                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }
        });
    </script>
</body>
</html>