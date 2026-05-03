<?php

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    use PasswordValidationRules;

    public string $password = '';

    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
    <form method="POST" wire:submit="deleteUser" class="space-y-5">
        <div class="flex items-start gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-500/10 text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-white">Tem certeza que deseja excluir sua conta?</h2>
                <p class="mt-1 text-sm text-slate-500">Após a exclusão, todos os seus dados serão permanentemente removidos. Insira sua senha para confirmar.</p>
            </div>
        </div>

        <div>
            <label for="delete-password" class="mb-2 flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.18em] text-slate-600">
                <span class="inline-flex h-5 w-5 items-center justify-center text-[#C9920A]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </span>
                Senha
            </label>
            <input id="delete-password" wire:model="password" type="password" required autocomplete="current-password" placeholder="Digite sua senha..."
                class="w-full rounded-lg border border-zinc-700 bg-slate-950 px-5 py-4 text-sm text-white outline-none transition focus:border-[#C9920A] focus:ring-2 focus:ring-[#C9920A]/15" />
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <flux:modal.close>
                <button type="button"
                    class="rounded-lg border border-zinc-700 bg-slate-950 px-5 py-3 text-sm font-semibold uppercase tracking-[0.15em] text-slate-400 transition hover:border-zinc-600 hover:text-white">
                    Cancelar
                </button>
            </flux:modal.close>

            <button type="submit" data-test="confirm-delete-user-button"
                class="inline-flex items-center gap-2 rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold uppercase tracking-[0.15em] text-white transition hover:bg-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                    <path d="M10 11v6" /><path d="M14 11v6" />
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                </svg>
                Excluir conta
            </button>
        </div>
    </form>
</flux:modal>