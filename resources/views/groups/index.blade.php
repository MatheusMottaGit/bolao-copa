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
        <flux:card>
            <flux:heading size="lg">Criar novo bolão</flux:heading>
            <form method="POST" action="{{ route('groups.store') }}" class="mt-4 flex gap-3">
                @csrf
                <flux:input name="name" placeholder="Nome do bolão" :value="old('name')" required class="flex-1" />
                <flux:button type="submit" variant="primary">Criar</flux:button>
            </form>
            @error('name') <flux:error>{{ $message }}</flux:error> @enderror
        </flux:card>

        {{-- Entrar por código --}}
        <flux:card>
            <flux:heading size="lg">Entrar em um bolão</flux:heading>
            <form method="POST" action="{{ route('groups.join') }}" class="mt-4 flex gap-3">
                @csrf
                <flux:input name="code" placeholder="Código (ex: ABC123)" maxlength="6" :value="old('code')" required class="flex-1 uppercase" />
                <flux:button type="submit" variant="outline">Entrar</flux:button>
            </form>
            @error('code') <flux:error>{{ $message }}</flux:error> @enderror
        </flux:card>

        {{-- Lista de bolões --}}
        @if ($groups->isNotEmpty())
            <flux:card>
                <flux:heading size="lg">Bolões participando</flux:heading>
                <flux:table class="mt-4">
                    <flux:columns>
                        <flux:column>Nome</flux:column>
                        <flux:column>Código</flux:column>
                        <flux:column>Membros</flux:column>
                        <flux:column></flux:column>
                    </flux:columns>
                    <flux:rows>
                        @foreach ($groups as $group)
                            <flux:row>
                                <flux:cell>{{ $group->name }}</flux:cell>
                                <flux:cell>
                                    <code class="font-mono font-bold">{{ $group->code }}</code>
                                </flux:cell>
                                <flux:cell>{{ $group->users_count }}</flux:cell>
                                <flux:cell>
                                    <flux:link :href="route('groups.show', $group)">Ver jogos</flux:link>
                                </flux:cell>
                            </flux:row>
                        @endforeach
                    </flux:rows>
                </flux:table>
            </flux:card>
        @else
            <flux:callout icon="information-circle">Você ainda não participa de nenhum bolão.</flux:callout>
        @endif
    </div>
</x-layouts::app>
