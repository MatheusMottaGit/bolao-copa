<x-layouts::app :title="'Admin — ' . $group->name">
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">{{ $group->name }}</flux:heading>
            <flux:link :href="route('admin.groups.index')">Voltar</flux:link>
        </div>

        <flux:card>
            <p class="text-sm text-zinc-500">Código: <code class="font-mono font-bold">{{ $group->code }}</code></p>
            <p class="text-sm text-zinc-500">Dono: {{ $group->owner->username }}</p>
            <p class="text-sm text-zinc-500 mt-1">Aposta mínima: R$ {{ number_format($group->current_min_bet, 2, ',', '.') }}</p>
        </flux:card>

        <flux:card>
            <flux:heading size="lg" class="mb-3">Membros</flux:heading>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>ID</flux:table.column>
                    <flux:table.column>Usuário</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($group->users as $user)
                        <flux:table.row>
                            <flux:table.cell>{{ $user->id }}</flux:table.cell>
                            <flux:table.cell>{{ $user->username }}</flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </flux:card>

        <form method="POST" action="{{ route('admin.groups.destroy', $group) }}"
              onsubmit="return confirm('Deletar este bolão permanentemente?')">
            @csrf
            @method('DELETE')
            <flux:button type="submit" variant="danger">Deletar bolão</flux:button>
        </form>
    </div>
</x-layouts::app>

