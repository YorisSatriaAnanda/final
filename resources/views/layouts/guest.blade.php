<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}" />
        <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/lucide@latest"></script>

        <style>
            @keyframes slideUpFade {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-reveal {
                animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            .glass-panel {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
                position: relative;
                overflow: hidden;
            }
            .glass-panel::before {
                content: "";
                position: absolute;
                inset: 0;
                background: url("https://grainy-gradients.vercel.app/noise.svg");
                opacity: 0.15;
                pointer-events: none;
                mix-blend-mode: overlay;
            }
            .logo-glow {
                filter: drop-shadow(0 0 20px rgba(218, 41, 28, 0.45));
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased selection:bg-red-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center bg-no-repeat relative selection:bg-red-500" 
             style="background-image: url('{{ asset('images/hero-coffee.jpg') }}');">
            
            {{-- Dark Overlay --}}
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[4px]"></div>

            <div class="relative z-10 w-full sm:max-w-md px-4 animate-reveal">
                <div class="flex flex-col items-center mb-10">
                    <a href="/" class="transition-all hover:scale-110 duration-500 logo-glow">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-32 object-contain">
                    </a>
                    <h1 class="text-white text-4xl font-extrabold mt-6 tracking-[0.2em] uppercase font-poppins">Mekarjaya</h1>
                </div>

                <div class="w-full px-8 py-10 glass-panel backdrop-blur-3xl border border-red-500/20 shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden sm:rounded-[3rem]">
                    {{ $slot }}
                </div>

                <div class="mt-8 text-center">
                    <a href="/" class="text-white/60 hover:text-white transition text-sm flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
