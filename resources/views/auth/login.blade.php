<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6" onsubmit="handleLoginSubmit(this)">
        @csrf

        <!-- Quick Login Buttons for Testing -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            <button type="button" onclick="fillLogin('admin@admin.com', 'password', this)" class="quick-login-btn text-xs bg-white/10 hover:bg-white/20 text-white py-3 rounded-xl transition-all duration-300 font-medium tracking-wide border border-transparent">
                Admin
            </button>
            <button type="button" onclick="fillLogin('kasir@kasir.com', 'password', this)" class="quick-login-btn text-xs bg-white/10 hover:bg-white/20 text-white py-3 rounded-xl transition-all duration-300 font-medium tracking-wide border border-transparent">
                Kasir
            </button>
            <button type="button" onclick="fillLogin('owner@owner.com', 'password', this)" class="quick-login-btn text-xs bg-white/10 hover:bg-white/20 text-white py-3 rounded-xl transition-all duration-300 font-medium tracking-wide border border-transparent">
                Owner
            </button>
        </div>

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Email')" class="text-white/80 group-focus-within:text-red-500 transition-colors duration-300 font-semibold text-sm uppercase tracking-widest pl-1" />
            <div class="relative mt-2">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-red-500 transition-colors duration-300">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </div>
                <input id="email" class="block w-full bg-white/[0.03] border-white/10 text-white focus:border-red-500/50 focus:ring-4 focus:ring-red-500/10 rounded-2xl py-4 pl-12 pr-4 transition-all duration-300 placeholder:text-gray-600" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@mekarjaya.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200 bg-red-900/40 px-4 py-2 rounded-xl border border-red-500/20 text-xs italic" />
        </div>

        <!-- Password -->
        <div class="group mt-6">
            <x-input-label for="password" :value="__('Password')" class="text-white/80 group-focus-within:text-red-500 transition-colors duration-300 font-semibold text-sm uppercase tracking-widest pl-1" />
            <div class="relative mt-2">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-red-500 transition-colors duration-300">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </div>
                <input id="password" class="block w-full bg-white/[0.03] border-white/10 text-white focus:border-red-500/50 focus:ring-4 focus:ring-red-500/10 rounded-2xl py-4 pl-12 pr-4 transition-all duration-300 placeholder:text-gray-600"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200 bg-red-900/40 px-4 py-2 rounded-xl border border-red-500/20 text-xs italic" />
        </div>

        <div class="pt-4">
            <button id="login-btn" type="submit" class="group relative w-full flex justify-center items-center gap-3 bg-red-700 hover:bg-red-600 text-white py-5 text-lg font-bold rounded-2xl shadow-[0_15px_30px_-5px_rgba(185,28,28,0.4)] transition-all duration-500 transform hover:-translate-y-1 active:scale-[0.98] overflow-hidden">
                <span id="btn-text" class="relative z-10 transition-all duration-300">{{ __('Masuk ke Admin') }}</span>
                <i id="btn-icon" data-lucide="arrow-right" class="w-5 h-5 relative z-10 transition-all duration-300 group-hover:translate-x-1"></i>
                
                {{-- Shine effect --}}
                <div class="absolute inset-0 w-1/2 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-[25deg] -translate-x-[150%] group-hover:translate-x-[250%] transition-all duration-1000 ease-in-out"></div>
            </button>
        </div>
    </form>

    <script>
        function handleLoginSubmit(form) {
            const btn = document.getElementById('login-btn');
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');
            
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            btnText.innerText = 'Memproses...';
            btnIcon.style.display = 'none';
        }

        function fillLogin(email, password, btn) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;

            // Kembalikan semua tombol ke warna semula
            const allBtns = document.querySelectorAll('.quick-login-btn');
            allBtns.forEach(b => {
                b.classList.remove('bg-red-600', 'border-red-400', 'shadow-[0_0_15px_rgba(220,38,38,0.5)]');
                b.classList.add('bg-white/10', 'border-transparent');
            });

            // Beri warna merah untuk tombol yang sedang aktif
            if (btn) {
                btn.classList.remove('bg-white/10', 'border-transparent');
                btn.classList.add('bg-red-600', 'border-red-400', 'shadow-[0_0_15px_rgba(220,38,38,0.5)]');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</x-guest-layout>
