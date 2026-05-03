<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-slate-950" x-data="{ open: false, userOpen: false }">

    {{-- Mobile drawer overlay --}}
    <div x-show="open" x-cloak @click="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm md:hidden">
    </div>

    {{-- Mobile drawer --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-800 bg-slate-950 md:hidden">

        {{-- Drawer header --}}
        <div class="flex h-20 items-center justify-between px-5">
            <div class="relative overflow-visible sm:px-12">
                <img src="{{ asset('images/Barbados_trident.png') }}" alt="Tridente"
                    class="pointer-events-none absolute left-1/2 top-1/2 size-14 -translate-x-1/2 -translate-y-1/2" />

                <div class="relative z-10 text-center">
                    <p class="mb-2 text-lg font-semibold text-white/80"
                        style="font-family:'RaudaSolidUnicase','Rauda Solid Unicase',sans-serif;">
                        <span class="inline-block font-black text-[#C9920A]">
                            TridentFC
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Drawer links --}}
        <nav class="flex-1 space-y-1 px-3 py-2">
            <a href="{{ route('groups.index') }}" wire:navigate @click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold uppercase tracking-[0.15em] transition
                        {{ request()->routeIs('groups.*') ? 'bg-[#C9920A]/10 text-[#C9920A]' : 'text-slate-400 hover:bg-slate-800 hover:text-[#C9920A]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0">
                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                    <path d="M4 22h16" />
                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" />
                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" />
                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" />
                </svg>
                Meus Bolões
            </a>

            <a href="{{ route('profile.edit') }}" wire:navigate @click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold uppercase tracking-[0.15em] transition
                        {{ request()->routeIs('profile.*') ? 'bg-[#C9920A]/10 text-[#C9920A]' : 'text-slate-400 hover:bg-slate-800 hover:text-[#C9920A]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0">
                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Configurações
            </a>
        </nav>

        {{-- Drawer user --}}
        <div class="border-t border-slate-800 px-5 py-4">
            <div class="mb-3">
                <p class="text-sm font-semibold text-white">{{ auth()->user()->username }}</p>
                <p class="text-xs text-slate-500">Minha conta</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-2 rounded-lg px-2 py-2 text-sm text-slate-400 transition hover:bg-red-500/10 hover:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Sair
                </button>
            </form>
        </div>
    </div>

    {{-- Top navbar --}}
    <nav class="sticky top-0 z-30 border-b border-slate-800 bg-slate-950 backdrop-blur-md">
        <div class="mx-auto max-w-5xl px-4">
            <div class="flex h-20 items-center justify-between gap-4">

                {{-- Logo --}}
                <div class="relative overflow-visible sm:px-12">
                    <img src="{{ asset('images/Barbados_trident.png') }}" alt="Tridente"
                        class="pointer-events-none absolute left-1/2 top-1/2 size-14 -translate-x-1/2 -translate-y-1/2" />

                    <div class="relative z-10 text-center">
                        <p class="mb-2 text-lg font-semibold text-white/80"
                            style="font-family:'RaudaSolidUnicase','Rauda Solid Unicase',sans-serif;">
                            <span class="inline-block font-black text-[#C9920A]">
                                TridentFC
                            </span>
                        </p>
                    </div>
                </div>

                {{-- Desktop nav links --}}
                <div class="hidden flex-1 items-center gap-1 md:flex">
                    <a href="{{ route('groups.index') }}" wire:navigate
                        class="group flex items-center gap-2 rounded-lg px-3 py-1.5 text-base font-semibold uppercase tracking-[0.15em] transition {{ request()->routeIs('groups.*') ? 'bg-[#C9920A]/10 text-[#C9920A]' : 'text-slate-400 hover:bg-slate-800 hover:text-[#C9920A]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4 transition {{ request()->routeIs('groups.*') ? 'text-[#C9920A]' : 'text-slate-500 group-hover:text-[#C9920A]' }}">
                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                            <path d="M4 22h16" />
                            <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" />
                            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" />
                            <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" />
                        </svg>
                        Bolões
                    </a>

                    <a href="{{ route('profile.edit') }}" wire:navigate
                        class="group flex items-center gap-2 rounded-lg px-3 py-1.5 text-base font-semibold uppercase tracking-[0.15em] transition
                                    {{ request()->routeIs('profile.*') ? 'bg-[#C9920A]/10 text-[#C9920A]' : 'text-slate-400 hover:bg-slate-800 hover:text-[#C9920A]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4 transition {{ request()->routeIs('profile.*') ? 'text-[#C9920A]' : 'text-slate-500 group-hover:text-[#C9920A]' }}">
                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        Configurações
                    </a>
                </div>

                {{-- Right: user dropdown + mobile toggle --}}
                <div class="flex items-center gap-2">

                    {{-- User dropdown (desktop) --}}
                    <div class="relative">
                        <button @click="userOpen = !userOpen" @click.outside="userOpen = false"
                            class="flex items-center gap-2 rounded-lg bg-slate-950 px-3 py-1.5 text-base font-semibold text-slate-300 transition hover:text-[#C9920A]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M20 21a8 8 0 0 0-16 0" />
                            </svg>
                            <span class="hidden sm:block text-lg">{{ auth()->user()->username }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 transition duration-200" :class="userOpen ? 'rotate-180' : ''">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <div x-show="userOpen" x-cloak x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            class="absolute right-0 top-full mt-2 w-48 origin-top-right rounded-xl border border-[#C9920A]/20 bg-slate-950 p-1 shadow-2xl">

                            <div class="border-b border-slate-800 px-3 py-2 mb-1">
                                <p class="text-lg font-semibold text-white">{{ auth()->user()->username }}</p>
                                <p class="text-base text-slate-500">Minha conta</p>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-base text-slate-300 transition hover:bg-red-500/10 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="h-5 w-5">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Mobile hamburger --}}
                    <button @click="open = true"
                        class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-700 text-slate-400 transition hover:border-[#C9920A]/50 hover:text-[#C9920A] md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                            <line x1="4" y1="6" x2="20" y2="6" />
                            <line x1="4" y1="12" x2="20" y2="12" />
                            <line x1="4" y1="18" x2="20" y2="18" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{ $slot }}

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>