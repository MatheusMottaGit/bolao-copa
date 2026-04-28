<x-layouts::app :title="__('Meus Bolões')">
    <div class="flex flex-col gap-6 max-w-3xl mx-auto">
        <flux:heading size="xl">Meus Bolões</flux:heading>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">{{ session('success') }}</flux:callout>
        @endif
        @if (session('error'))
            <flux:callout variant="danger" icon="x-circle">{{ session('error') }}</flux:callout>
        @endif

        {{-- Criar bolão --}}
        {{-- <flux:card> --}}
            {{-- <flux:heading size="lg">Criar novo bolão</flux:heading> --}}
            <form method="POST" action="{{ route('groups.store') }}" class="mt-4 grid gap-3">
                @csrf
                <input name="name" value="{{ old('name') }}" type="text" required placeholder="Nome do bolão"
                    class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-5 py-4 text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15" />
                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-3 rounded-lg bg-[#C9920A] px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-lg shadow-[#C9920A]/20 transition hover:bg-[#b47f0a]"
                >
                    <span>Criar bolão</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </button>
            </form>
            @error('name') <flux:error>{{ $message }}</flux:error> @enderror
        {{-- </flux:card> --}}

        <div class="flex items-center gap-4">
            <div class="h-px flex-1 bg-zinc-700"></div>
            <span class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-600">ou</span>
            <div class="h-px flex-1 bg-zinc-700"></div>
        </div>

        {{-- Entrar por código --}}
        {{-- <flux:card> --}}
            {{-- <flux:heading size="lg">Entrar em um bolão</flux:heading> --}}
            <form method="POST" action="{{ route('groups.join') }}" class="grid gap-3">
                @csrf
                <input name="code" value="{{ old('code') }}" type="text" required maxlength="6" placeholder="Código (ex: ABC123)"
                    class="w-full uppercase rounded-lg border border-zinc-700 bg-slate-950 px-5 py-4 text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15" />
                <button type="submit" class="inline-flex w-full items-center justify-center gap-3 rounded-lg bg-[#C9920A] px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-lg shadow-[#C9920A]/20 transition hover:bg-[#b47f0a]">
                    <span>Entrar no bolão</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </button>
            </form>
            @error('code') <flux:error>{{ $message }}</flux:error> @enderror
        {{-- </flux:card> --}}

        {{-- Lista de bolões --}}
        @if ($groups->isNotEmpty())
            <div class="flex items-center gap-4">
                <div class="h-px flex-1 bg-zinc-800"></div>
                <span class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-600">Participando</span>
                <div class="h-px flex-1 bg-zinc-800"></div>
            </div>

            <div class="grid grid-cols-1 gap-3">
                @foreach ($groups as $group)
                    <a href="{{ route('groups.show', $group) }}"
                        class="group flex items-center justify-between rounded-xl border border-zinc-800 bg-slate-900 px-5 py-4 transition hover:border-[#C9920A]/40 hover:bg-slate-800">
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#C9920A]/10 text-[#C9920A]">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                    <path d="M4 22h16"></path>
                                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white transition group-hover:text-[#C9920A]">{{ $group->name }}</p>
                                <div class="mt-1 flex items-center gap-3">
                                    <span class="rounded bg-zinc-800 px-2 py-0.5 font-mono text-xs font-bold text-slate-400">{{ $group->code }}</span>
                                    <span class="flex items-center gap-1 text-xs text-slate-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        {{ $group->users_count }} {{ $group->users_count === 1 ? 'membro' : 'membros' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0 text-slate-600 transition group-hover:translate-x-0.5 group-hover:text-[#C9920A]">
                            <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                @endforeach
            </div>
        @else
            <flux:callout icon="information-circle">Você ainda não participa de nenhum bolão.</flux:callout>
        @endif
    </div>
</x-layouts::app>