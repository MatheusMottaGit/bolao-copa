<x-layouts::app :title="'Ranking — ' . $group->name">
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Ranking — {{ $group->name }}</flux:heading>
            <flux:link :href="route('groups.show', $group)">Voltar aos jogos</flux:link>
        </div>

        <flux:card>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>#</flux:table.column>
                    <flux:table.column>Usuário</flux:table.column>
                    <flux:table.column>Pontos</flux:table.column>
                    <flux:table.column>Total apostado</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($ranking as $i => $member)
                        <flux:table.row>
                            <flux:table.cell class="font-bold text-lg">{{ $i + 1 }}</flux:table.cell>
                            <flux:table.cell>{{ $member->username }}</flux:table.cell>
                            <flux:table.cell class="font-bold">{{ $member->total_points ?? 0 }}</flux:table.cell>
                            <flux:table.cell>R$ {{ number_format($member->total_bet ?? 0, 2, ',', '.') }}</flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </flux:card>

        <flux:text size="sm" class="text-zinc-500">
            Aposta mínima atual: R$ {{ number_format($group->current_min_bet, 2, ',', '.') }}
        </flux:text>
    </div>
</x-layouts::app>

