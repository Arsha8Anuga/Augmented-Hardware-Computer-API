@extends('layouts.app')

@section('content')
<div
    class="fixed inset-0 -z-20 bg-cover bg-center blur-[8px] brightness-75 scale-110"
    style="background-image: url('{{ asset('img/koke.jpg') }}')"
></div>

<div class="fixed inset-0 -z-10 bg-gradient-to-br from-[#0a1114]/95 to-[#0a1114]/80"></div>

<div class="relative z-10 max-w-7xl mx-auto px-5 py-8 md:py-10 text-slate-100">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8 pb-5 border-b border-cyan-400/20">
        <div class="min-w-0">
            <div class="flex items-center gap-4 mb-3">
                <div
                    class="w-12 h-12 rounded-xl bg-cover bg-center border border-cyan-400/40 shadow-[0_0_15px_rgba(0,188,212,0.45)] shrink-0"
                    style="background-image: url('{{ asset('img/logo-ar.jpg') }}')"
                ></div>

                <div>
                    <h2 class="font-extrabold text-[1.8rem] tracking-wide text-cyan-400 [text-shadow:0_0_15px_rgba(0,188,212,0.6)] leading-none">
                        Dashboard
                    </h2>
                    <p class="text-sm text-slate-400 mt-1">Manage your structured data visually</p>
                </div>
            </div>

            <div
                id="breadcrumb"
                class="flex flex-wrap items-center gap-2 text-sm text-slate-300"
            ></div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
            {{-- User Panel --}}
            <div class="flex items-center gap-3 rounded-2xl border border-cyan-400/15 bg-white/5 px-4 py-3 backdrop-blur-md">
                <div class="w-11 h-11 rounded-xl border border-cyan-400/25 bg-cyan-400/10 flex items-center justify-center text-cyan-300 font-bold text-lg shadow-[0_0_15px_rgba(0,188,212,0.15)]">
                    {{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">
                        {{ auth()->user()->full_name ?? 'User' }}
                    </p>
                    <p class="text-xs text-cyan-300/80 truncate">
                       <span>@</span>{{ auth()->user()->username ?? 'username' }}
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-3 items-center">
                <div id="backs"></div>

                <button
                    id="addBtn"
                    class="inline-flex items-center justify-center gap-2 bg-cyan-400 text-[#0d1a1d] font-bold px-6 py-3 rounded-xl shadow-[0_0_20px_rgba(0,188,212,0.35)] transition-all duration-300 hover:bg-cyan-300 hover:shadow-[0_0_30px_rgba(0,188,212,0.6)] hover:-translate-y-0.5 active:translate-y-0"
                >
                    <span class="text-lg leading-none">+</span>
                    <span>Add</span>
                </button>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-red-400/20 bg-transparent text-red-400 font-semibold transition-all duration-300 hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-[0_0_18px_rgba(255,77,77,0.35)]"
                    >
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="bg-[#0d1a1d]/75 backdrop-blur-[20px] border border-cyan-400/20 rounded-[24px] p-5 md:p-8 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
        <div class="flex items-center justify-between px-2 md:px-3 pb-4 border-b border-cyan-400/15 mb-6">
            <div>
                <p class="text-cyan-400 font-bold uppercase text-[0.8rem] tracking-[2px] opacity-90">
                    Data Explorer
                </p>
                <p class="text-sm text-slate-400 mt-1">Browse, edit, and organize your node structure</p>
            </div>
        </div>

        <div id="app" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5"></div>
    </div>
</div>

@include('dashboard.partials.modal')

<script>
    window.dashboardConfig = {
        path: @json($path ?? ''),
        dashboardUrl: @json(url('/dashboard')),
        apiDashboardUrl: @json(url('/api/dashboard')),
        csrfToken: @json(csrf_token()),
    };
</script>

@vite('resources/js/dashboard/index.js')
@endsection