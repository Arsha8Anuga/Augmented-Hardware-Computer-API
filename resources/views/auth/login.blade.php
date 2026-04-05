@extends('layouts.auth')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white">Login</h2>
    <p class="text-sm text-slate-400 mt-1">Masuk ke akun kamu untuk melanjutkan.</p>
</div>

<form action="{{ url('/login') }}" method="POST" class="space-y-5">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">
            Email
        </label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            placeholder="Masukkan email"
            class="w-full rounded-2xl border border-cyan-400/15 bg-white/5 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400/35 transition"
        >
        @error('email')
            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
            Password
        </label>
        <input
            id="password"
            name="password"
            type="password"
            placeholder="Masukkan password"
            class="w-full rounded-2xl border border-cyan-400/15 bg-white/5 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400/35 transition"
        >
        @error('password')
            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between gap-4">
        <label class="inline-flex items-center gap-2 text-sm text-slate-300 cursor-pointer">
            <input
                type="checkbox"
                name="remember"
                class="w-4 h-4 rounded border-cyan-400/30 bg-transparent text-cyan-400 focus:ring-cyan-400/40"
            >
            <span>Remember me</span>
        </label>
    </div>

    <button
        type="submit"
        class="w-full rounded-2xl bg-cyan-400 text-[#0d1a1d] font-bold px-6 py-3.5 shadow-[0_0_20px_rgba(0,188,212,0.35)] transition-all duration-300 hover:bg-cyan-300 hover:shadow-[0_0_28px_rgba(0,188,212,0.55)] hover:-translate-y-[1px]"
    >
        Login
    </button>
</form>

<div class="mt-6 text-center text-sm text-slate-400">
    Belum punya akun?
    <a href="{{ url('/register') }}" class="text-cyan-400 hover:text-cyan-300 transition">
        Register
    </a>
</div>
@endsection