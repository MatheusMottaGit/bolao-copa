<x-layouts::app :title="__('Admin — Bolões')">
    <div class="flex flex-col gap-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Admin — Bolões</flux:heading>
            <flux:link :href="route('admin.groups.create')" variant="primary">Criar bolão</flux:link>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">{{ session('success') }}</flux:callout>
        @endif

        <flux:card>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Nome</flux:table.column>
                    <flux:table.column>Código</flux:table.column>
                    <flux:table.column>Dono</flux:table.column>
                    <flux:table.column>Membros</flux:table.column>
                    <flux:table.column></flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @forelse ($groups as $group)
                        <flux:table.row>
                            <flux:table.cell>{{ $group->name }}</flux:table.cell>
                            <flux:table.cell><code class="font-mono">{{ $group->code }}</code></flux:table.cell>
                            <flux:table.cell>{{ $group->owner->username }}</flux:table.cell>
                            <flux:table.cell>{{ $group->users_count }}</flux:table.cell>
                            <flux:table.cell>
                                <div class="flex gap-2">
                                    <flux:link :href="route('admin.groups.show', $group)">Ver</flux:link>
                                    <form method="POST" action="{{ route('admin.groups.destroy', $group) }}"
                                          onsubmit="return confirm('Deletar este bolão?')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="danger">Deletar</flux:button>
                                    </form>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:cell colspan="5" class="text-center text-zinc-400">Nenhum bolão cadastrado.</flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts::app>

