<x-layouts::app :title="'Ranking — ' . $group->name">
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Ranking — {{ $group->name }}</flux:heading>
            <flux:link :href="route('groups.show', $group)">Voltar aos jogos</flux:link>
        </div>

        @php $prizes = $group->prizes(); @endphp

        <flux:card>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>#</flux:table.column>
                    <flux:table.column>Usuário</flux:table.column>
                    <flux:table.column>Pontos</flux:table.column>
                    <flux:table.column>Prêmio</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($ranking as $i => $member)
                        <flux:table.row>
                            <flux:table.cell class="font-bold text-lg">{{ $i + 1 }}</flux:table.cell>
                            <flux:table.cell>{{ $member->username }}</flux:table.cell>
                            <flux:table.cell class="font-bold">{{ $member->total_points ?? 0 }}</flux:table.cell>
                            <flux:table.cell>
                                @if ($i < 3 && ($prizes[$i] ?? 0) > 0)
                                    <span class="font-semibold text-green-500">R$ {{ number_format($prizes[$i], 2, ',', '.') }}</span>
                                @else
                                    <span class="text-zinc-500">—</span>
                                @endif
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </flux:card>

        <flux:text size="sm" class="text-zinc-500">
            Bolo total: R$ {{ number_format($group->pot(), 2, ',', '.') }} · Buy-in: R$ {{ number_format($group->buy_in, 2, ',', '.') }} · Premiação 70% / 20% / 10%
        </flux:text>
    </div>
</x-layouts::app>

