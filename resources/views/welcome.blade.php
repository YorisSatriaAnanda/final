<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mekarjaya Coffee</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <a href="#contact" class="hover:text-red-700">Contact</a>
                <a href="{{ route('login') }}" class="bg-red-700 text-white px-6 py-2 rounded-xl hover:bg-red-800">
                    Login
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
            <div>
                <img src="{{ asset('images/about-coffee.png') }}" alt="About Coffee" class="w-full max-w-lg mx-auto">
            </div>

            <div>
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

    {{-- Our Menu --}}
    <section id="menu" class="py-24 bg-[#f4f4f4]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
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
                                        <p class="text-xl font-bold text-gray-800">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="relative">
                                        @if($menu->is_best_seller)
                                            <span class="absolute -top-5 -right-2 text-yellow-400 text-3xl">★</span>
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

            {{-- Best Seller --}}
            <div class="pt-16">
                <h2 class="text-5xl font-bold text-center text-red-700 mb-12">Best Seller</h2>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($bestSellers as $item)
                        <div class="bg-white rounded-3xl shadow-lg p-6 text-center hover:shadow-xl transition">
                            <div class="mb-4">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                        class="w-44 h-44 object-contain mx-auto">
                                @else
                                    <img src="{{ asset('images/default-menu.png') }}" alt="{{ $item->name }}"
                                        class="w-44 h-44 object-contain mx-auto">
                                @endif
                            </div>
                            <h3 class="text-2xl font-bold mb-2">{{ $item->name }}</h3>
                            <p class="text-gray-600 mb-3">{{ $item->description }}</p>
                            <p class="text-xl font-bold text-red-700">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="py-24 bg-[#f4f4f4]">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-5xl font-bold text-red-700 text-center mb-16">Contact Us</h2>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <form class="space-y-5">
                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="email" placeholder="Email"
                            class="w-full rounded-xl border-0 bg-gray-200 px-4 py-4 focus:ring-2 focus:ring-red-500">
                        <input type="text" placeholder="Nama"
                            class="w-full rounded-xl border-0 bg-gray-200 px-4 py-4 focus:ring-2 focus:ring-red-500">
                    </div>

                    <textarea rows="8" placeholder="Pesan"
                        class="w-full rounded-xl border-0 bg-gray-200 px-4 py-4 focus:ring-2 focus:ring-red-500"></textarea>

                    <button type="submit"
                        class="bg-red-700 text-white px-10 py-3 rounded-xl hover:bg-red-800">
                        Send
                    </button>
                </form>

                <div class="text-center">
                    <img src="{{ asset('images/logo-big.png') }}" alt="Logo Besar" class="w-48 mx-auto opacity-80">
                </div>
            </div>
        </div>
    </section>

    <script>
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