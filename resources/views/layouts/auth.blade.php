<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0a1114] text-slate-100 overflow-x-hidden">

    {{-- Background --}}
    <div
        class="fixed inset-0 -z-20 bg-cover bg-center blur-[8px] brightness-75 scale-110"
        style="background-image: url('{{ asset('img/koke.jpg') }}')"
    ></div>

    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-[#0a1114]/95 to-[#0a1114]/80"></div>

    <div class="relative min-h-screen flex items-center justify-center px-5 py-10">
        <div class="w-full max-w-md">
            {{-- Brand --}}
            <div class="flex flex-col items-center text-center mb-8">
                <div
                    class="w-16 h-16 rounded-2xl bg-cover bg-center border border-cyan-400/50 shadow-[0_0_20px_rgba(0,188,212,0.45)] mb-4"
                    style="background-image: url('{{ asset('img/logo-ar.jpg') }}')"
                ></div>

                <h1 class="text-3xl font-extrabold tracking-wide text-cyan-400 [text-shadow:0_0_15px_rgba(0,188,212,0.55)]">
                    KELOMPOK 2
                </h1>

                <p class="text-sm text-slate-400 mt-2">
                    Access your dashboard securely
                </p>
            </div>

            {{-- Card --}}
            <div class="relative overflow-hidden rounded-[24px] border border-cyan-400/20 bg-[#0d1a1d]/80 backdrop-blur-[20px] shadow-[0_20px_50px_rgba(0,0,0,0.45)]">
                <div class="absolute inset-x-0 top-0 h-[1px] bg-gradient-to-r from-transparent via-cyan-400/40 to-transparent"></div>

                <div class="p-8">
                    @if(session('success'))
                        <div class="mb-5 rounded-2xl border border-cyan-400/20 bg-cyan-400/10 px-4 py-3 text-sm text-cyan-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-5 rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>