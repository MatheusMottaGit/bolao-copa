<?php

use Livewire\Component;

new class extends Component {}; ?>

<div>
    <flux:modal.trigger name="confirm-user-deletion">
        <button type="button"
            class="inline-flex items-center gap-2 rounded-lg border border-red-900/60 bg-red-950/30 px-5 py-3 text-sm font-semibold uppercase tracking-[0.15em] text-red-400 transition hover:border-red-700 hover:bg-red-950/60 hover:text-red-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                <polyline points="3 6 5 6 21 6" />
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                <path d="M10 11v6" />
                <path d="M14 11v6" />
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
            </svg>
            Excluir conta
        </button>
    </flux:modal.trigger>

    <livewire:pages::settings.delete-user-modal />
</div>