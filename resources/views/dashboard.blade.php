<x-layouts::app :title="__('Início')">
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">
        <flux:heading size="xl">Bem-vindo, {{ auth()->user()->username }}!</flux:heading>

        <flux:card>
            <flux:heading size="lg">Bolão da Copa</flux:heading>
            <flux:text class="mt-2">Faça palpites nos jogos da Copa do Mundo e dispute com seus amigos!</flux:text>
            <div class="mt-4">
                <flux:link :href="route('groups.index')" variant="primary">Ver meus bolões</flux:link>
            </div>
        </flux:card>

        @if (auth()->user()->is_admin)
            <flux:card>
                <flux:heading size="lg">Administração</flux:heading>
                <div class="mt-3">
                    <flux:link :href="route('admin.groups.index')" variant="outline">Painel Admin</flux:link>
                </div>
            </flux:card>
        @endif
    </div>
</x-layouts::app>
