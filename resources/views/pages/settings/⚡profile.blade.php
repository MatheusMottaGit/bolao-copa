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

<section class="mx-auto max-w-lg space-y-6">
    <div class="flex items-center gap-3">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#C9920A]/10 text-[#C9920A]">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                <circle cx="12" cy="12" r="3" />
            </svg>
        </div>
        <div>
            <h1 class="text-xl font-semibold text-white">Configurações</h1>
            <p class="text-sm text-slate-500">Gerencie seu perfil e conta</p>
        </div>
    </div>

    <div class="h-px bg-zinc-800"></div>

    {{-- Perfil --}}
    <div>
        <h2 class="mb-1 text-base font-semibold text-white">Perfil</h2>
        <p class="mb-5 text-sm text-slate-500">Atualize seu nome de usuário</p>

        <form wire:submit="updateProfileInformation" class="space-y-4">
            <div>
                <label for="username" class="mb-2 flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.18em] text-slate-600">
                    <span class="inline-flex h-5 w-5 items-center justify-center text-[#C9920A]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                            <path d="M20 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M4 21v-2a4 4 0 0 1 3-3.87" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </span>
                    Usuário
                </label>
                <input id="username" wire:model="username" name="username" type="text" required autofocus autocomplete="username" placeholder="Digite seu usuário..."
                    class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-5 py-4 text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15" />
                @error('username')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="inline-flex w-full items-center justify-center gap-3 rounded-lg bg-[#C9920A] px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-lg shadow-[#C9920A]/20 transition hover:bg-[#b47f0a]">
                <span>Salvar</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    <polyline points="17 21 17 13 7 13 7 21" />
                    <polyline points="7 3 7 8 15 8" />
                </svg>
            </button>
        </form>
    </div>

    <div class="h-px bg-zinc-800"></div>

    {{-- Excluir conta --}}
    <div class="rounded-xl border border-red-900/40 bg-slate-900 p-6">
        <h2 class="mb-1 text-base font-semibold text-white">Excluir conta</h2>
        <p class="mb-5 text-sm text-slate-500">Exclua sua conta e todos os seus dados permanentemente</p>

        <livewire:pages::settings.delete-user-form />
    </div>

</section>