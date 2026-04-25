<?php

use App\Concerns\ProfileValidationRules;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Configurações de perfil')] class extends Component {
    use ProfileValidationRules;

    public string $username = '';

    public function mount(): void
    {
        $this->username = Auth::user()->username;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);
        $user->save();

        Flux::toast(variant: 'success', text: __('Perfil atualizado.'));
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Configurações de perfil') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Perfil')" :subheading="__('Atualize seu nome de usuário')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="username" :label="__('Usuário')" type="text" required autofocus autocomplete="username" />

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">
                    {{ __('Salvar') }}
                </flux:button>
            </div>
        </form>

        <livewire:pages::settings.delete-user-form />
    </x-pages::settings.layout>
</section>
