<x-layouts::auth :title="__('Entrar')">
    <div class="w-full max-w-lg overflow-visible">
        <div class="relative overflow-visible sm:px-12">
            <img src="{{ asset('images/Barbados_trident.png') }}" alt="Tridente" class="pointer-events-none absolute left-1/2 top-1/2 size-44 -translate-x-1/2 -translate-y-1/2" />

            <div class="relative z-10 text-center">
                <p class="mb-6 text-5xl font-semibold text-white/80" style="font-family:'RaudaSolidUnicase','Rauda Solid Unicase',sans-serif;">
                    <span class="inline-block font-black text-[#C9920A]">
                        TridentFC
                    </span>
                </p>
            </div>
        </div>

        <div class="px-8 py-10 sm:px-12">
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="username" class="mb-2 flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.18em] text-slate-600">
                        <span class="inline-flex h-5 w-5 items-center justify-center text-[#C9920A]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M20 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M4 21v-2a4 4 0 0 1 3-3.87"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        Usuário
                    </label>
                    <input id="username" name="username" value="{{ old('username') }}" type="text" required autofocus autocomplete="username" placeholder="Digite seu usuário..."
                        class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-5 py-4 text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15" />
                    @error('username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.18em] text-slate-600">
                        <span class="inline-flex h-5 w-5 items-center justify-center text-[#C9920A]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        Senha
                    </label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Digite sua senha..."
                        class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-5 py-4 text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between gap-4">
                    <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-zinc-300 text-[#C9920A] focus:ring-[#C9920A]" {{ old('remember') ? 'checked' : '' }}>
                        Lembrar de mim
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#C9920A] hover:text-[#b47f0a]">Esqueceu?</a>
                    @endif
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center gap-3 rounded-lg bg-[#C9920A] px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-lg shadow-[#C9920A]/20 transition hover:bg-[#b47f0a]">
                    <span>ENTRAR</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </form>

            @if (Route::has('register'))
                <p class="mt-6 text-center text-sm text-slate-500">
                    Ainda não tem conta?
                    <a href="{{ route('register') }}" class="font-semibold text-[#C9920A] hover:text-[#b47f0a]">Cadastre-se</a>
                </p>
            @endif
        </div>
    </div>
</x-layouts::auth>
