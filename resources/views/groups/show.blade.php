<x-layouts::app :title="$group->name">
    <div class="flex flex-col gap-6 max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <a href="{{ route('groups.index') }}" class="mb-2 inline-flex items-center gap-1 text-sm font-semibold uppercase tracking-[0.18em] text-slate-500 transition hover:text-[#C9920A]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    Meus Bolões
                </a>
                <flux:heading size="xl">{{ $group->name }}</flux:heading>
                <div class="mt-2 flex items-center gap-2">
                    @if (auth()->user()->is_admin)
                        <span class="text-base text-slate-500">Código:</span>
                        <span class="rounded bg-[#C9920A]/10 px-2 py-0.5 font-mono text-sm font-bold text-[#C9920A]">{{ $group->code }}</span>
                    @else
                        <span class="invisible text-base">‌</span>
                    @endif
                </div>
            </div>
            <div class="flex shrink-0 flex-col gap-2 sm:mt-1 sm:flex-row sm:items-center">
                <a href="{{ route('groups.participants', $group) }}"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-zinc-700 px-3 py-2 text-sm font-semibold uppercase tracking-[0.18em] text-slate-300 transition hover:border-zinc-500 hover:text-white sm:flex-none sm:px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Participantes
                </a>
                <a href="{{ route('ranking.show', $group) }}"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-[#C9920A] px-3 py-2 text-sm font-semibold uppercase tracking-[0.18em] text-[#C9920A] transition hover:bg-[#C9920A]/10 sm:flex-none sm:px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    Ranking
                </a>
            </div>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 7500)" x-show="show" x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                class="fixed bottom-6 right-6 z-50 flex items-center gap-3 rounded-xl border border-green-500/30 bg-slate-900 px-4 py-3 shadow-2xl shadow-black/40">
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-green-500/15 text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <span class="text-sm font-semibold text-white">{{ session('success') }}</span>
                <button type="button" @click="show = false" aria-label="Fechar" class="ml-2 text-slate-500 transition hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        @endif
        @if (session('error'))
            <flux:callout variant="danger" icon="x-circle">{{ session('error') }}</flux:callout>
        @endif
        @if ($errors->any())
            <flux:callout variant="danger" icon="x-circle">
                {{ $errors->first() }}
            </flux:callout>
        @endif

        {{-- Resumo do bolo (apenas admin) --}}
        @if (auth()->user()->is_admin)
            @php
                $pot = $group->pot();
                $myBet = optional($members->firstWhere('id', auth()->id()))->pivot->bet_amount ?? 0;
            @endphp
            <div class="grid grid-cols-3 gap-3">
                <div class="rounded-xl border border-zinc-800 bg-slate-900 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Bolo total</p>
                    <p class="mt-1 text-lg font-black text-[#C9920A]">R$ {{ number_format($pot, 2, ',', '.') }}</p>
                </div>
                <div class="rounded-xl border border-zinc-800 bg-slate-900 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Sua aposta</p>
                    <p class="mt-1 text-lg font-black text-white">R$ {{ number_format($myBet, 2, ',', '.') }}</p>
                </div>
                <div class="rounded-xl border border-green-500/30 bg-green-500/5 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Prêmio (1º lugar)</p>
                    <p class="mt-1 text-lg font-black text-green-400">R$ {{ number_format($pot, 2, ',', '.') }}</p>
                </div>
            </div>
        @endif

        {{-- Busca --}}
        <form method="GET" action="{{ route('groups.show', $group) }}" class="flex items-center gap-2">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Pesquisar time..." class="w-full rounded-lg border border-zinc-700 bg-slate-900 py-2 pl-9 pr-4 text-base text-white placeholder-slate-500 outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15" />
            </div>
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#C9920A] px-4 py-2.5 text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-[#b47f0a]">
                Buscar
            </button>
            @if ($search)
                <a href="{{ route('groups.show', $group) }}"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-700 px-3 py-2 text-xs font-semibold text-slate-400 transition hover:border-zinc-500 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Limpar
                </a>
            @endif
        </form>

        <hr class="border-zinc-800" />

        {{-- Jogos agrupados por data --}}
        @forelse ($games as $date => $dayGames)
            @php $isPastDay = \Carbon\Carbon::parse($date)->lt(\Carbon\Carbon::today()); @endphp
            <details @if (! $isPastDay) open @endif class="group/details">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-3 rounded-lg border border-zinc-800 bg-slate-900/50 px-4 py-3 select-none hover:bg-slate-900 transition">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0 text-[#C9920A] transition-transform group-open/details:rotate-90">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-300">
                            {{ str_replace('-feira', '', \Carbon\Carbon::parse($date)->locale('pt_BR')->translatedFormat('l, d \d\e F')) }}
                        </span>
                    </div>
                    <span class="rounded-full bg-zinc-800 px-2 py-0.5 text-xs font-semibold text-slate-400">
                        {{ count($dayGames) }} {{ count($dayGames) === 1 ? 'jogo' : 'jogos' }}
                    </span>
                </summary>

                <div class="mt-3 flex flex-col gap-4">
                @foreach ($dayGames as $game)
                @php
                    $prediction = $userPredictions->get((int) $game->id);
                    $gamePredictions = $allPredictions->get((int) $game->id, collect());
                @endphp
                <div id="game-{{ $game->id }}" class="scroll-mt-24 rounded-xl border border-zinc-800 bg-slate-900 overflow-hidden">

                    {{-- Status bar --}}
                    <div class="flex items-center justify-between border-b border-zinc-800 px-4 py-2.5">
                        <span class="text-xs text-slate-500 sm:text-sm">
                            {{ $game->starts_at->format('d/m/Y · H:i') }}
                        </span>
                        @if ($game->status === 'finished')
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 sm:text-sm">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                                Encerrado
                            </span>
                        @elseif ($game->status === 'in_progress')
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-400 sm:text-sm">
                                <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-green-400"></span>
                                Ao vivo
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#C9920A] sm:text-sm">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#C9920A]"></span>
                                Aguardando
                            </span>
                        @endif
                    </div>

                    {{-- Placar / Times --}}
                    <div class="grid grid-cols-3 items-center gap-2 px-3 py-4 sm:gap-4 sm:px-6 sm:py-5">
                        <div class="flex flex-col items-center gap-2">
                            @if ($game->home_crest)
                                <img src="{{ $game->home_crest }}" alt="{{ $game->home_team }}"
                                    class="h-9 w-9 rounded-lg object-contain sm:h-11 sm:w-11" />
                            @else
                                <div class="h-9 w-9 rounded-lg bg-zinc-800 sm:h-11 sm:w-11"></div>
                            @endif
                            <p class="text-center text-xs font-bold leading-tight text-white sm:text-base">{{ $game->home_team }}</p>
                        </div>
                        <div class="text-center">
                            @if ($game->status === 'finished')
                                <p class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                                    {{ $game->home_score }} <span class="text-slate-500">×</span> {{ $game->away_score }}
                                </p>
                            @elseif ($game->status === 'in_progress')
                                <p class="text-2xl font-black tracking-tight text-green-400 sm:text-3xl">
                                    {{ $game->home_score }} <span class="text-green-600">×</span> {{ $game->away_score }}
                                </p>
                            @else
                                <p class="text-base font-bold text-slate-500 sm:text-lg">VS</p>
                            @endif
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            @if ($game->away_crest)
                                <img src="{{ $game->away_crest }}" alt="{{ $game->away_team }}"
                                    class="h-9 w-9 rounded-lg object-contain sm:h-11 sm:w-11" />
                            @else
                                <div class="h-9 w-9 rounded-lg bg-zinc-800 sm:h-11 sm:w-11"></div>
                            @endif
                            <p class="text-center text-xs font-bold leading-tight text-white sm:text-base">{{ $game->away_team }}</p>
                        </div>
                    </div>

                    {{-- Palpite --}}
                    @if ($game->isOpen())
                        <div class="border-t border-zinc-800 bg-slate-950/40 px-4 py-4 sm:px-5">
                            <form method="POST" action="{{ route('predictions.store', [$group, $game]) }}">
                                @csrf
                                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-end">
                                    <div class="w-full sm:w-auto">
                                        <p class="mb-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Palpite</p>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="home_score" min="0" max="99"
                                                value="{{ $prediction?->home_score }}"
                                                placeholder="0"
                                                class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-3 py-2 text-center text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15 sm:w-16" />
                                            <span class="shrink-0 font-bold text-slate-500">×</span>
                                            <input type="number" name="away_score" min="0" max="99"
                                                value="{{ $prediction?->away_score }}"
                                                placeholder="0"
                                                class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-3 py-2 text-center text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15 sm:w-16" />
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="{{ $prediction ? 'border border-[#C9920A] bg-transparent text-[#C9920A] hover:bg-[#C9920A]/10' : 'bg-[#C9920A] text-white shadow-lg shadow-[#C9920A]/20 hover:bg-[#b47f0a]' }} inline-flex w-full items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold uppercase tracking-[0.18em] transition sm:ml-auto sm:w-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        {{ $prediction ? 'Atualizar palpite' : 'Salvar palpite' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @elseif ($prediction)
                        <div class="border-t border-zinc-800 bg-slate-950/40 px-4 py-3 sm:px-5">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Seu palpite</span>
                                    <span class="rounded bg-zinc-800 px-2 py-0.5 font-mono text-sm font-bold text-white">
                                        {{ $prediction->home_score }} × {{ $prediction->away_score }}
                                    </span>
                                </div>
                                @if ($game->status === 'finished')
                                    <span class="ml-auto rounded-lg px-3 py-1 text-sm font-bold {{ $prediction->points > 0 ? 'bg-green-500/10 text-green-400' : 'bg-zinc-800 text-slate-500' }}">
                                        {{ $prediction->points }} {{ $prediction->points === 1 ? 'ponto' : 'pontos' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Palpites dos participantes --}}
                    <details class="group/preds border-t border-zinc-800">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-2 px-4 py-2.5 select-none transition hover:bg-slate-800/40 sm:px-5">
                                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 transition-transform group-open/preds:rotate-90">
                                        <path d="m9 18 6-6-6-6"></path>
                                    </svg>
                                    Palpites dos participantes
                                </div>
                                <span class="rounded-full bg-zinc-800 px-2 py-0.5 text-xs font-semibold text-slate-400">{{ $gamePredictions->count() }}</span>
                            </summary>
                            <div class="divide-y divide-zinc-800/60">
                                @foreach ($members as $member)
                                    @php $memberPred = $gamePredictions->get((int) $member->id); @endphp
                                    <div class="flex items-center gap-3 px-4 py-2.5 sm:px-5">
                                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#C9920A]/10 text-xs font-bold text-[#C9920A]">
                                            {{ strtoupper(substr($member->username, 0, 1)) }}
                                        </div>
                                        <span class="min-w-0 flex-1 truncate text-sm {{ $member->id === auth()->id() ? 'font-bold text-[#C9920A]' : 'text-slate-300' }}">
                                            {{ $member->username }}
                                            @if ($member->id === auth()->id())
                                                <span class="text-xs font-normal text-slate-500">(você)</span>
                                            @endif
                                        </span>
                                        @if ($memberPred)
                                            <span class="rounded bg-zinc-800 px-2 py-0.5 font-mono text-xs font-bold text-white">
                                                {{ $memberPred->home_score }} × {{ $memberPred->away_score }}
                                            </span>
                                            @if ($game->status === 'finished')
                                                <span class="shrink-0 text-xs font-bold {{ $memberPred->points > 0 ? 'text-green-400' : 'text-slate-600' }}">
                                                    {{ $memberPred->points }} pts
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-xs text-slate-600">Sem palpite</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </details>
                </div>
                @endforeach
                </div>
            </details>
        @empty
            <flux:callout icon="information-circle">
                {{ $search ? "Nenhum jogo encontrado para \"$search\"." : 'Nenhum jogo cadastrado ainda.' }}
            </flux:callout>
        @endforelse

        {{-- Ranking resumido --}}
        @if ($ranking->isNotEmpty())
            <div class="rounded-xl border border-zinc-800 bg-slate-900 overflow-hidden">
                <div class="flex items-center justify-between border-b border-zinc-800 px-5 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Ranking</p>
                    <a href="{{ route('ranking.show', $group) }}" class="text-xs font-semibold text-[#C9920A] transition hover:text-[#b47f0a]">Ver completo</a>
                </div>
                <div class="divide-y divide-zinc-800">
                    @foreach ($ranking as $i => $member)
                        @php
                            $medals = ['🥇', '🥈', '🥉'];
                            $isTop = $i < 3;
                        @endphp
                        <div class="flex items-center gap-4 px-5 py-3">
                            <span class="w-6 text-center text-sm {{ $isTop ? 'text-base' : 'font-bold text-slate-600' }}">
                                {{ $isTop ? $medals[$i] : $i + 1 }}
                            </span>
                            <span class="flex-1 text-sm font-semibold {{ $i === 0 ? 'text-[#C9920A]' : 'text-white' }}">
                                {{ $member->username }}
                            </span>
                            @if (auth()->user()->is_admin && $i === 0 && $group->pot() > 0)
                                <span class="text-xs font-semibold text-green-400">R$ {{ number_format($group->pot(), 2, ',', '.') }}</span>
                            @endif
                            <span class="min-w-12 text-right text-sm font-bold {{ $i === 0 ? 'text-[#C9920A]' : 'text-white' }}">
                                {{ $member->total_points ?? 0 }} <span class="text-xs font-normal text-slate-500">pts</span>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-layouts::app>
