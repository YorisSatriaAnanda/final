<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mekarjaya Coffee</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-[#f4f4f4] text-gray-900">

    {{-- Navbar --}}
    <nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                <h1 class="text-2xl font-bold text-red-700 uppercase">Mekarjaya</h1>
            </div>

            <div class="hidden md:flex items-center gap-8 text-lg">
                <a href="#home" class="hover:text-red-700">Home</a>
                <a href="#about" class="hover:text-red-700">About</a>
                <a href="#menu" class="hover:text-red-700">Menu</a>
                <a href="#ulasan" class="hover:text-red-700">Ulasan</a>
                <a href="{{ route('login') }}" class="bg-red-700 text-white px-6 py-2 rounded-xl hover:bg-red-800">
                    Admin
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section id="home" class="min-h-screen bg-cover bg-center flex items-center justify-center relative"
        style="background-image: url('{{ asset('images/hero-coffee.jpg') }}');">
        <div class="absolute inset-0 bg-black/55"></div>

        <div class="relative z-10 text-center px-6 max-w-4xl">
            <h1 class="text-white text-5xl md:text-7xl font-light leading-tight mb-8">
                Mekarjaya, <br> Just for you!
            </h1>
            <p class="text-white/90 text-xl md:text-3xl mb-10 font-serif">
                Mekar Jaya Coffee menyajikan kopi berkualitas <br>
                dengan suasana nyaman dan minimalis.
            </p>
            <a href="#menu" class="bg-white text-gray-900 px-10 py-4 rounded-2xl text-2xl shadow hover:bg-gray-200">
                Order Now
            </a>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="py-24 bg-[#f4f4f4]">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="reveal">
                <img src="{{ asset('images/about-coffee.png') }}" alt="About Coffee" class="w-full max-w-lg mx-auto">
            </div>

            <div class="reveal delay-200">
                <h2 class="text-6xl font-serif mb-6">About Us</h2>
                <p class="text-red-600 text-2xl mb-4">
                    Just For You <span class="text-gray-800 text-xl">Every cup tells a story</span>
                </p>
                <p class="text-xl leading-relaxed mb-6">
                    Mekar Jaya Coffee adalah tempat di mana aroma kopi segar bertemu dengan suasana hangat.
                    Kami menghadirkan kopi berkualitas dari biji pilihan, diseduh dengan penuh perhatian untuk
                    menciptakan rasa terbaik di setiap cangkir.
                </p>
                <p class="text-xl leading-relaxed mb-8">
                    Tidak hanya kopi, kami juga menyediakan berbagai minuman dan camilan yang cocok untuk menemani
                    waktu santai, bekerja, maupun berkumpul bersama orang terdekat.
                </p>

                <a href="#menu" class="bg-red-400 text-white px-6 py-3 rounded-full hover:bg-red-500">
                    View our menu
                </a>
            </div>
        </div>
    </section>

    {{-- Best Seller --}}
    <section id="bestseller" class="pt-24 pb-8 bg-[#f4f4f4]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="reveal">
                <h2 class="text-5xl font-bold text-center text-red-700 mb-12">Best Seller</h2>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($bestSellers as $item)
                        <div class="bg-white rounded-3xl shadow-lg p-8 text-center hover:shadow-2xl transition relative overflow-hidden group">
                            @if($item->is_best_seller)
                                <div class="absolute top-0 right-0">
                                    <div class="bg-yellow-400 text-white px-10 py-1 rotate-45 translate-x-8 translate-y-3 shadow-md font-bold text-xs uppercase tracking-widest border border-yellow-300">
                                        Best
                                    </div>
                                </div>
                            @endif
                            <div class="mb-4">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                        class="w-44 h-44 object-contain mx-auto group-hover:scale-110 transition duration-500">
                                @else
                                    <img src="{{ asset('images/default-menu.png') }}" alt="{{ $item->name }}"
                                        class="w-44 h-44 object-contain mx-auto group-hover:scale-110 transition duration-500">
                                @endif
                            </div>
                            <h3 class="text-2xl font-bold mb-2">{{ $item->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $item->description }}</p>
                            <div class="flex items-center justify-center gap-3">
                                @if($item->discount_amount > 0)
                                    <p class="text-sm line-through text-red-300">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                @endif
                                <p class="text-2xl font-black text-red-700">Rp {{ number_format($item->final_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Our Menu --}}
    <section id="menu" class="pt-12 pb-24 bg-[#f4f4f4]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14 pt-10 border-t border-gray-200 reveal">
                <h2 class="text-6xl font-bold text-red-700 mb-6">Our Menu</h2>
                <p class="text-2xl max-w-4xl mx-auto font-semibold">
                    Enjoy a variety of delightful drinks and light meals crafted to complement your coffee experience.
                </p>
            </div>

            {{-- kategori --}}
            <div class="flex flex-wrap justify-center gap-4 mb-14">
                <button onclick="filterMenu('all')" class="filter-btn bg-red-700 text-white px-8 py-3 rounded-xl text-xl">
                    View All
                </button>

                @foreach($categories as $category)
                    <button onclick="filterMenu('{{ $category->id }}')" class="filter-btn bg-red-700 text-white px-8 py-3 rounded-xl text-xl">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            {{-- list menu per kategori --}}
            @foreach($categories as $category)
                @if($category->menus->count())
                    <div class="menu-group mb-16" data-category="{{ $category->id }}">
                        <h3 class="inline-block bg-red-700 text-white px-8 py-3 rounded-2xl text-2xl font-semibold mb-10">
                            {{ $category->name }}
                        </h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($category->menus as $menu)
                                <div class="bg-white rounded-3xl shadow-md p-6 flex items-center justify-between hover:shadow-xl transition">
                                    <div class="pr-4">
                                        <h4 class="text-2xl font-semibold mb-2">{{ $menu->name }}</h4>
                                        <p class="text-gray-600 mb-4">{{ $menu->description }}</p>
                                        <div class="flex items-center gap-2">
                                            @if($menu->discount_amount > 0)
                                                <p class="text-sm line-through text-gray-400">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                            @endif
                                            <p class="text-xl font-bold text-gray-800">Rp {{ number_format($menu->final_price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    <div class="relative">
                                        @if($menu->is_best_seller)
                                            <div class="absolute -top-7 -right-4 z-10 rotate-12 scale-110">
                                                <div class="bg-yellow-400 text-white p-2 rounded-full shadow-lg border-2 border-white flex items-center justify-center">
                                                    <i data-lucide="star" class="w-6 h-6 fill-current"></i>
                                                </div>
                                            </div>
                                        @endif

                                        @if($menu->image)
                                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                                                class="w-32 h-32 object-contain">
                                        @else
                                            <img src="{{ asset('images/default-menu.png') }}" alt="{{ $menu->name }}"
                                                class="w-32 h-32 object-contain">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach


        </div>
    </section>

    {{-- Gallery / Suasana --}}
    <section id="gallery" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-5xl font-bold text-red-700 mb-16 reveal">Suasana Mekarjaya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="overflow-hidden rounded-[40px] shadow-lg reveal delay-100">
                    <img src="{{ asset('images/gallery_1.png') }}" alt="Interior 1" class="w-full h-[500px] object-cover hover:scale-110 transition duration-700">
                </div>
                <div class="overflow-hidden rounded-[40px] shadow-lg reveal delay-300">
                    <img src="{{ asset('images/gallery_2.png') }}" alt="Coffee 1" class="w-full h-[500px] object-cover hover:scale-110 transition duration-700">
                </div>
                <div class="overflow-hidden rounded-[40px] shadow-lg reveal delay-500">
                    <img src="{{ asset('images/gallery_3.png') }}" alt="Exterior 1" class="w-full h-[500px] object-cover hover:scale-110 transition duration-700">
                </div>
            </div>
        </div>
    </section>

    {{-- Maps --}}
    <section id="maps" class="pt-24 pb-12 bg-[#f4f4f4]">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-5xl font-bold text-red-700 text-center mb-16">Kunjungi Kami</h2>
            <div class="overflow-hidden rounded-[30px] shadow-2xl border-4 border-white">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.70507656175383!2d106.7812511789058!3d-6.6119379886677345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5001b1da1d3%3A0x933528604d9819f4!2sMekarjaya%20Coffee%2C%20Bogor!5e0!3m2!1sid!2sid!4v1775496696914!5m2!1sid!2sid" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    {{-- Ulasan --}}
    <section id="ulasan" class="py-24 bg-[#f4f4f4]">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-5xl font-bold text-red-700 text-center mb-16">Beri Kami Ulasan</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 text-center" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <form method="POST" action="{{ route('reviews.store') }}" class="space-y-5">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="email" name="email" placeholder="Email (Opsional)"
                            class="w-full rounded-xl border-0 bg-gray-200 px-4 py-4 focus:ring-2 focus:ring-red-500">
                        <input type="text" name="name" placeholder="Nama Anda" required
                            class="w-full rounded-xl border-0 bg-gray-200 px-4 py-4 focus:ring-2 focus:ring-red-500">
                    </div>

                    <textarea name="message" rows="8" placeholder="Tulis ulasan Anda di sini..." required
                        class="w-full rounded-xl border-0 bg-gray-200 px-4 py-4 focus:ring-2 focus:ring-red-500"></textarea>

                    <button type="submit"
                        class="bg-red-700 text-white px-10 py-3 rounded-xl hover:bg-red-800">
                        Kirim Ulasan
                    </button>
                </form>

                <div class="text-center">
                    <img src="{{ asset('images/logo-big.png') }}" alt="Logo Besar" class="w-48 mx-auto opacity-80">
                </div>
            </div>
        </div>
    </section>


    {{-- Footer & Jam Operasional --}}
    <footer class="bg-gray-900 text-white pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-16 mb-16">
            {{-- Brand info --}}
            <div class="reveal">
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 invert">
                    <h2 class="text-3xl font-bold uppercase tracking-widest text-red-500">Mekarjaya</h2>
                </div>
                <p class="text-gray-400 text-lg leading-relaxed">
                    Lebih dari sekadar kopi. Kami menyajikan kenyamanan dan cerita di setiap cangkir yang Anda nikmati.
                </p>
                <div class="flex gap-4 mt-8">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-red-600 transition">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-red-600 transition">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-red-600 transition">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            {{-- Jam Operasional --}}
            <div class="reveal delay-200">
                <h3 class="text-2xl font-bold mb-8 border-b border-gray-700 pb-2 inline-block">Jam Operasional</h3>
                <ul class="space-y-4 text-lg">
                    <li class="flex justify-between">
                        <span class="text-gray-400">Senin - Jumat</span>
                        <span class="font-semibold">09:00 - 22:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-400">Sabtu - Minggu</span>
                        <span class="font-semibold">08:00 - 23:00</span>
                    </li>
                </ul>
                <div class="mt-8 pt-6 border-t border-gray-800">
                    <p class="text-sm italic text-red-400 font-medium">Buka setiap hari kecuali hari besar tertentu.</p>
                </div>
            </div>

            {{-- Hubungi Kami --}}
            <div class="reveal delay-400">
                <h3 class="text-2xl font-bold mb-8 border-b border-gray-700 pb-2 inline-block">Lokasi & Kontak</h3>
                <ul class="space-y-4 text-lg text-gray-400">
                    <li class="flex gap-3">
                        <i data-lucide="map-pin" class="w-6 h-6 text-red-500 shrink-0"></i>
                        <span>Jl. Pajajaran No. 123, Bogor, Jawa Barat.</span>
                    </li>
                    <li class="flex gap-3">
                        <i data-lucide="phone" class="w-6 h-6 text-red-500 shrink-0"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex gap-3">
                        <i data-lucide="mail" class="w-6 h-6 text-red-500 shrink-0"></i>
                        <span>hello@mekarjayacoffee.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4 text-gray-500 text-sm">
            <p>&copy; 2026 Mekarjaya Coffee. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Service</a>
            </div>
        </div>
    </footer>

    {{-- WhatsApp Floating Button --}}
    <a href="https://wa.me/6281234567890" target="_blank"
       class="fixed bottom-10 right-10 z-50 bg-[#25D366] text-white p-4 rounded-full shadow-2xl hover:scale-110 active:scale-95 transition-all group flex items-center gap-2 overflow-hidden max-w-[60px] hover:max-w-[200px] duration-500">
        <i data-lucide="message-circle" class="w-8 h-8"></i>
        <span class="font-bold opacity-0 group-hover:opacity-100 whitespace-nowrap pr-4 transition-all duration-500">Chat Mekarjaya</span>
    </a>

    {{-- Script & Styles --}}
    <style>
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
        .delay-400 { transition-delay: 0.4s; }
        .delay-500 { transition-delay: 0.5s; }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();

            // Scroll Reveal Animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("active");
                    }
                });
            }, { 
                threshold: 0.15 
            });

            document.querySelectorAll(".reveal").forEach((el) => {
                observer.observe(el);
            });
        });

        // Menu Filter
        function filterMenu(categoryId) {
            const groups = document.querySelectorAll('.menu-group');
            groups.forEach(group => {
                if (categoryId === 'all') {
                    group.style.display = 'block';
                } else {
                    group.style.display = group.dataset.category === categoryId ? 'block' : 'none';
                }
            });
        }
    </script>
</body>
</html>