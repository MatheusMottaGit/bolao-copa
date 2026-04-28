<x-layouts::app :title="__('Admin — Criar Bolão')">
    <div class="flex flex-col gap-6 max-w-xl mx-auto">
        <flux:heading size="xl">Criar Bolão</flux:heading>

        <flux:card>
            <form method="POST" action="{{ route('admin.groups.store') }}" class="flex flex-col gap-4">
                @csrf

                <flux:input name="name" :label="__('Nome do bolão')" :value="old('name')" required />
                @error('name') <flux:error>{{ $message }}</flux:error> @enderror

                <flux:input name="owner_id" :label="__('ID do dono (user id)')" type="number" :value="old('owner_id')" required />
                @error('owner_id') <flux:error>{{ $message }}</flux:error> @enderror

                <div class="flex gap-3">
                    <flux:button type="submit" variant="primary">Criar</flux:button>
                    <flux:link :href="route('admin.groups.index')">Cancelar</flux:link>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
