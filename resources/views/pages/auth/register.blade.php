<x-layouts::auth :title="__('Cadastro')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Criar conta')" :description="__('Escolha um usuário e senha para participar')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="username"
                :label="__('Usuário')"
                :value="old('username')"
                type="text"
                required
                autofocus
                autocomplete="username"
                placeholder="seu_usuario"
            />

            <flux:input
                name="password"
                :label="__('Senha')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Senha')"
                viewable
            />

            <flux:input
                name="password_confirmation"
                :label="__('Confirmar senha')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirmar senha')"
                viewable
            />

            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Criar conta') }}
            </flux:button>
        </form>

        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Já tem conta?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Entrar') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
