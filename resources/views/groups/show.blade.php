<x-layouts::app :title="$group->name">
    <div class="flex flex-col gap-6 max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <a href="{{ route('groups.index') }}" class="mb-2 inline-flex items-center gap-1 text-sm font-semibold uppercase tracking-[0.18em] text-slate-500 transition hover:text-[#C9920A]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    Meus Bolões
                </a>
                <flux:heading size="xl">{{ $group->name }}</flux:heading>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-base text-slate-500">Código:</span>
                    <span class="rounded bg-[#C9920A]/10 px-2 py-0.5 font-mono text-sm font-bold text-[#C9920A]">{{ $group->code }}</span>
                </div>
            </div>
            <a href="{{ route('ranking.show', $group) }}"
                class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-[#C9920A] px-4 py-2 text-sm font-semibold uppercase tracking-[0.18em] text-[#C9920A] transition hover:bg-[#C9920A]/10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                Ranking
            </a>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">{{ session('success') }}</flux:callout>
        @endif
        @if (session('error'))
            <flux:callout variant="danger" icon="x-circle">{{ session('error') }}</flux:callout>
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

        {{-- Jogos --}}
        @forelse ($games as $date => $dayGames)
            <div>
                <p class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">
                    {{ \Carbon\Carbon::parse($date)->locale('pt_BR')->translatedFormat('l, d \d\e F') }}
                </p>
                <div class="flex flex-col gap-4">
            @foreach ($dayGames as $game)
            @php $prediction = $userPredictions[$game->id] ?? null; @endphp
            <div class="rounded-xl border border-zinc-800 bg-slate-900 overflow-hidden">

                {{-- Status bar --}}
                <div class="flex items-center justify-between border-b border-zinc-800 px-5 py-2.5">
                    <span class="text-sm text-slate-500">
                        {{ $game->starts_at->format('d/m/Y · H:i') }}
                    </span>
                    @if ($game->status === 'finished')
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                            Encerrado
                        </span>
                    @elseif ($game->status === 'in_progress')
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-green-400">
                            <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-green-400"></span>
                            Ao vivo
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#C9920A]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#C9920A]"></span>
                            Aguardando
                        </span>
                    @endif
                </div>

                {{-- Placar / Times --}}
                <div class="grid grid-cols-3 items-center gap-4 px-6 py-5">
                    <div class="flex flex-col items-center gap-2">
                        @if ($game->home_crest)
                            <img src="{{ $game->home_crest }}" alt="{{ $game->home_team }}"
                                class="h-11 w-11 rounded-lg object-contain" />
                        @else
                            <div class="h-11 w-11 rounded-lg bg-zinc-800"></div>
                        @endif
                        <p class="text-center text-base font-bold text-white">{{ $game->home_team }}</p>
                    </div>
                    <div class="text-center">
                        @if ($game->status === 'finished')
                            <p class="text-3xl font-black tracking-tight text-white">
                                {{ $game->home_score }} <span class="text-slate-500">×</span> {{ $game->away_score }}
                            </p>
                        @elseif ($game->status === 'in_progress')
                            <p class="text-3xl font-black tracking-tight text-green-400">
                                {{ $game->home_score }} <span class="text-green-600">×</span> {{ $game->away_score }}
                            </p>
                        @else
                            <p class="text-lg font-bold text-slate-500">VS</p>
                        @endif
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        @if ($game->away_crest)
                            <img src="{{ $game->away_crest }}" alt="{{ $game->away_team }}"
                                class="h-11 w-11 rounded-lg object-contain" />
                        @else
                            <div class="h-11 w-11 rounded-lg bg-zinc-800"></div>
                        @endif
                        <p class="text-center text-base font-bold text-white">{{ $game->away_team }}</p>
                    </div>
                </div>

                {{-- Palpite --}}
                @if ($game->isOpen())
                    <div class="border-t border-zinc-800 bg-slate-950/40 px-5 py-4">
                        <form method="POST" action="{{ route('predictions.store', [$group, $game]) }}">
                            @csrf
                            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-end">
                                <div class="w-full sm:w-auto">
                                    <p class="mb-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Palpite</p>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="home_score" min="0" max="99"
                                            value="{{ $prediction?->home_score ?? old('home_score') }}"
                                            placeholder="0"
                                            class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-3 py-2 text-center text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15 sm:w-16" />
                                        <span class="shrink-0 font-bold text-slate-500">×</span>
                                        <input type="number" name="away_score" min="0" max="99"
                                            value="{{ $prediction?->away_score ?? old('away_score') }}"
                                            placeholder="0"
                                            class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-3 py-2 text-center text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15 sm:w-16" />
                                    </div>
                                </div>
                                <div class="w-full sm:w-auto">
                                    <p class="mb-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Aposta</p>
                                    <input type="number" name="bet_amount" min="{{ $group->current_min_bet }}" step="0.01"
                                        value="{{ $prediction?->bet_amount ?? old('bet_amount') }}"
                                        placeholder="R$ 0,00"
                                        class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-3 py-2 text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15 sm:w-36" />
                                </div>
                                <button type="submit"
                                    class="{{ $prediction ? 'border border-[#C9920A] bg-transparent text-[#C9920A] hover:bg-[#C9920A]/10' : 'bg-[#C9920A] text-white shadow-lg shadow-[#C9920A]/20 hover:bg-[#b47f0a]' }} inline-flex w-full items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold uppercase tracking-[0.18em] transition sm:ml-auto sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    {{ $prediction ? 'Atualizar palpite' : 'Salvar palpite' }}
                                </button>
                            </div>
                            @if ($group->current_min_bet > 0)
                                <p class="mt-2 text-xs text-slate-600">Aposta mínima: R$ {{ number_format($group->current_min_bet, 2, ',', '.') }}</p>
                            @endif
                        </form>
                    </div>
                @elseif ($prediction)
                    <div class="border-t border-zinc-800 bg-slate-950/40 px-5 py-3">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Seu palpite</span>
                                <span class="rounded bg-zinc-800 px-2 py-0.5 font-mono text-sm font-bold text-white">
                                    {{ $prediction->home_score }} × {{ $prediction->away_score }}
                                </span>
                            </div>
                            @if ($prediction->bet_amount)
                                <span class="text-xs text-slate-500">Aposta: R$ {{ number_format($prediction->bet_amount, 2, ',', '.') }}</span>
                            @endif
                            @if ($game->status === 'finished')
                                <span class="ml-auto rounded-lg px-3 py-1 text-sm font-bold {{ $prediction->points > 0 ? 'bg-green-500/10 text-green-400' : 'bg-zinc-800 text-slate-500' }}">
                                    {{ $prediction->points }} {{ $prediction->points === 1 ? 'ponto' : 'pontos' }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            @endforeach
                </div>
            </div>
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
                            <span class="text-xs text-slate-500">R$ {{ number_format($member->total_bet ?? 0, 2, ',', '.') }}</span>
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