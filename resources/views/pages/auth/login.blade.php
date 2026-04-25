<x-layouts::auth :title="__('Entrar')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Bolão da Copa')" :description="__('Entre com seu usuário e senha')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
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
                autocomplete="current-password"
                :placeholder="__('Senha')"
                viewable
            />

            <flux:checkbox name="remember" :label="__('Lembrar de mim')" :checked="old('remember')" />

            <flux:button variant="primary" type="submit" class="w-full">
                {{ __('Entrar') }}
            </flux:button>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Não tem conta?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Cadastre-se') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts::auth>
