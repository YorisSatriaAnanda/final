@extends('layouts.admin')

@section('content')

    <div class="mb-8 flex items-center gap-4">
        {{-- Sidebar Toggle --}}
        <button id="sidebar-toggle" class="hidden lg:flex items-center justify-center w-12 h-12 bg-white shadow-sm rounded-2xl hover:bg-red-50 hover:text-red-700 transition border border-gray-100 text-gray-400 group">
            <i data-lucide="menu" class="w-6 h-6 transition-transform group-hover:scale-110"></i>
        </button>
        
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kasir / POS</h1>
            <p class="text-gray-500 mt-1 uppercase tracking-wider text-[11px] font-bold">Pilih menu dan kelola pesanan customer.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-2xl bg-red-100 text-red-700 px-5 py-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-100 text-red-700 px-5 py-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- LEFT: MENU LIST --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Search & Filter --}}
            <div class="bg-white rounded-[30px] p-6 shadow-md">
                <form method="GET" action="{{ route('cashier.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari menu..."
                               class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>

                    <div>
                        <select name="category_id"
                                class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3 flex gap-3">
                        <button class="bg-red-700 text-white px-6 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
                            Filter
                        </button>

                        <a href="{{ route('cashier.index') }}"
                           class="bg-gray-200 text-gray-800 px-6 py-3 rounded-2xl hover:bg-gray-300 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Menu Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($menus as $menu) 
                    <div class="bg-white rounded-[28px] shadow-md overflow-hidden hover:shadow-xl transition flex flex-col h-full border border-gray-100">
                        <div class="h-52 bg-gray-100 relative">
                            @if($menu->is_best_seller)
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="flex items-center gap-1.5 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 py-1.5 rounded-xl text-[10px] tracking-wider font-black shadow-lg border border-yellow-300/50 uppercase">
                                        <i data-lucide="star" class="w-3.5 h-3.5 fill-current text-white"></i>
                                        Best Seller
                                    </span>
                                </div>
                            @endif

                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}"
                                     alt="{{ $menu->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i data-lucide="coffee" class="w-12 h-12"></i>
                                </div>
                            @endif
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex-1">
                                <div class="flex items-start justify-between gap-3 mb-2">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400">{{ $menu->category->name }}</p>
                                        <h3 class="text-xl font-bold text-gray-900 leading-tight mt-1">{{ $menu->name }}</h3>
                                    </div>
                                </div>
    
                                <p class="text-sm text-gray-500 leading-relaxed mb-4">
                                    {{ $menu->description ? \Illuminate\Support\Str::limit($menu->description, 60) : 'Tidak ada deskripsi.' }}
                                </p>
                            </div>

                            <div class="mt-auto">
                                <div class="flex items-center justify-between mb-4 pt-4 border-t border-gray-50">
                                    <div>
                                        @if($menu->discount_amount > 0)
                                            <p class="text-xs line-through text-red-400">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                        @endif
                                        <p class="text-red-700 text-2xl font-black">
                                            Rp {{ number_format($menu->final_price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-[11px] font-bold uppercase tracking-wider {{ $menu->stock > 10 ? 'text-gray-400' : 'text-red-500' }} mt-1">
                                            Stok: {{ $menu->stock > 0 ? $menu->stock : 'Habis' }}
                                        </p>
                                    </div>
                                </div>
    
                                <form action="{{ route('cashier.add', $menu->id) }}" method="POST">
                                    @csrf
                                    <button class="w-full bg-red-700 text-white py-3.5 rounded-2xl hover:bg-red-800 transition shadow-md flex items-center justify-center gap-2 font-bold active:scale-[0.98]">
                                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                        Tambah
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-[28px] p-10 shadow-md text-center text-gray-500">
                        Belum ada menu tersedia.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT: CART --}}
        <div class="space-y-6">

            <div class="bg-white rounded-[30px] p-6 shadow-md sticky top-6 max-h-[calc(100vh-48px)] overflow-y-auto border border-gray-100 custom-scrollbar">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Keranjang</h2>

                    @if(count($cart) > 0)
                        <form action="{{ route('cashier.clear') }}" method="POST"
                              onsubmit="return confirm('Kosongkan semua keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm text-red-700 font-semibold hover:underline">
                                Kosongkan
                            </button>
                        </form>
                    @endif
                </div>

                <div class="space-y-4 max-h-[350px] overflow-y-auto pr-1">
                    @forelse($cart as $item)
                        <div class="bg-[#fafafa] rounded-2xl p-4">
                            <div class="flex gap-4">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}"
                                         class="w-16 h-16 rounded-2xl object-cover" alt="{{ $item['name'] }}">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center text-red-700">
                                        <i data-lucide="coffee" class="w-8 h-8"></i>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </p>

                                    <div class="flex items-center gap-2 mt-3">
                                        <form action="{{ route('cashier.decrease', $item['id']) }}" method="POST">
                                            @csrf
                                            <button class="w-8 h-8 rounded-xl bg-gray-200 hover:bg-gray-300">-</button>
                                        </form>

                                        <span class="font-semibold w-8 text-center">{{ $item['qty'] }}</span>

                                        <form action="{{ route('cashier.increase', $item['id']) }}" method="POST">
                                            @csrf
                                            <button class="w-8 h-8 rounded-xl bg-red-700 text-white hover:bg-red-800">+</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="font-bold text-gray-900">
                                        Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                    </p>

                                    <form action="{{ route('cashier.remove', $item['id']) }}" method="POST" class="mt-3">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-12">
                            <div class="flex justify-center mb-4">
                                <div class="bg-gray-100 p-6 rounded-full">
                                    <i data-lucide="shopping-cart" class="w-12 h-12"></i>
                                </div>
                            </div>
                            <p class="text-lg">Keranjang masih kosong.</p>
                        </div>
                    @endforelse
                </div>

                {{-- CHECKOUT FORM --}}
                <div class="border-t border-gray-200 mt-6 pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-2xl font-bold text-red-700">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <form action="{{ route('cashier.checkout') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Customer (Opsional)</label>
                            <input type="text"
                                   name="customer_name"
                                   value="{{ old('customer_name') }}"
                                   placeholder="Contoh: Walk In / Budi"
                                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <select name="payment_method"
                                    class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:outline-none">
                                <option value="">Pilih pembayaran</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                <option value="debit" {{ old('payment_method') == 'debit' ? 'selected' : '' }}>Debit</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diskon</label>
                            <div class="flex gap-2 mb-3">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="discount_type" value="fixed" class="hidden peer" checked id="type_fixed">
                                    <div class="text-center py-2.5 rounded-xl border border-gray-200 peer-checked:bg-red-700 peer-checked:text-white peer-checked:border-red-700 transition text-sm font-medium">
                                        Rp (Nominal)
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="discount_type" value="percent" class="hidden peer" id="type_percent">
                                    <div class="text-center py-2.5 rounded-xl border border-gray-200 peer-checked:bg-red-700 peer-checked:text-white peer-checked:border-red-700 transition text-sm font-medium">
                                        % (Persen)
                                    </div>
                                </label>
                            </div>
                            <input type="text"
                                   id="discount_input"
                                   name="discount_value"
                                   value="{{ old('discount_value', 0) }}"
                                   placeholder="Contoh: 5.000 atau 10"
                                   class="w-full rupiah-input rounded-2xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Uang Bayar</label>
                            <input type="text"
                                   id="paid_amount_input"
                                   name="paid_amount"
                                   value="{{ old('paid_amount') }}"
                                   placeholder="Contoh: 50.000"
                                   class="w-full rupiah-input rounded-2xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        </div>

                        {{-- Total Akhir & Kembalian Display --}}
                        <div class="bg-gray-50 rounded-2xl p-4 space-y-2 border border-gray-100">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Total Akhir</span>
                                <span id="final_total_display" class="font-bold text-gray-900">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-200 pt-2">
                                <span>Kembalian</span>
                                <span id="change_display" class="text-red-700">Rp 0</span>
                            </div>
                        </div>

                        <button
                            class="w-full bg-red-700 text-white py-4 rounded-2xl font-semibold hover:bg-red-800 transition shadow-md">
                            Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subtotal = {{ $subtotal }};
            const discountInput = document.getElementById('discount_input');
            const paidAmountInput = document.getElementById('paid_amount_input');
            const finalTotalDisplay = document.getElementById('final_total_display');
            const changeDisplay = document.getElementById('change_display');

            function updateCalculations() {
                const discountRaw = discountInput.value.replace(/\./g, '') || 0;
                const discountValue = parseFloat(discountRaw) || 0;
                const discountType = document.querySelector('input[name="discount_type"]:checked').value;
                
                const paidRaw = paidAmountInput.value.replace(/\./g, '') || 0;
                const paidAmount = parseInt(paidRaw) || 0;
                
                let discountAmount = 0;
                if (discountType === 'percent') {
                    discountAmount = (subtotal * discountValue) / 100;
                } else {
                    discountAmount = discountValue;
                }
                
                const finalTotal = subtotal - discountAmount;
                const change = paidAmount - finalTotal;

                finalTotalDisplay.innerText = formatRupiah(Math.max(0, finalTotal).toString());
                changeDisplay.innerText = formatRupiah(Math.max(0, change).toString());
            }

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
                return 'Rp ' + rupiah;
            }

            discountInput.addEventListener('input', updateCalculations);
            paidAmountInput.addEventListener('input', updateCalculations);

            document.querySelectorAll('input[name="discount_type"]').forEach(radio => {
                radio.addEventListener('change', updateCalculations);
            });

        });
    </script>


@endsection