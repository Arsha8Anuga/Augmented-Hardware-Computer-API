@extends('layouts.auth')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white">Register</h2>
    <p class="text-sm text-slate-400 mt-1">Buat akun baru untuk masuk ke dashboard.</p>
</div>

<form action="{{ url('/register') }}" method="POST" class="space-y-5">
    @csrf

    <div>
        <label for="username" class="block text-sm font-medium text-slate-300 mb-2">
            Username
        </label>
        <input
            id="username"
            name="username"
            type="text"
            value="{{ old('username') }}"
            placeholder="Masukkan username"
            class="w-full rounded-2xl border border-cyan-400/15 bg-white/5 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400/35 transition"
        >
        @error('username')
            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="full_name" class="block text-sm font-medium text-slate-300 mb-2">
            Full Name
        </label>
        <input
            id="full_name"
            name="full_name"
            type="text"
            value="{{ old('full_name') }}"
            placeholder="Masukkan nama lengkap"
            class="w-full rounded-2xl border border-cyan-400/15 bg-white/5 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400/35 transition"
        >
        @error('full_name')
            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

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

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">
            Confirm Password
        </label>
        <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            placeholder="Ulangi password"
            class="w-full rounded-2xl border border-cyan-400/15 bg-white/5 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400/35 transition"
        >
    </div>

    <button
        type="submit"
        class="w-full rounded-2xl bg-cyan-400 text-[#0d1a1d] font-bold px-6 py-3.5 shadow-[0_0_20px_rgba(0,188,212,0.35)] transition-all duration-300 hover:bg-cyan-300 hover:shadow-[0_0_28px_rgba(0,188,212,0.55)] hover:-translate-y-[1px]"
    >
        Create Account
    </button>
</form>

<div class="mt-6 text-center text-sm text-slate-400">
    Sudah punya akun?
    <a href="{{ url('/login') }}" class="text-cyan-400 hover:text-cyan-300 transition">
        Login
    </a>
</div>
@endsection