<x-layouts::app :title="'Participantes — ' . $group->name">
    <div class="flex flex-col gap-6 max-w-2xl mx-auto">

        <div>
            <a href="{{ route('groups.show', $group) }}" class="mb-2 inline-flex items-center gap-1 text-sm font-semibold uppercase tracking-[0.18em] text-slate-500 transition hover:text-[#C9920A]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
                {{ $group->name }}
            </a>
            <flux:heading size="xl">Participantes</flux:heading>
            <p class="mt-1 text-sm text-slate-500">{{ $members->count() }} {{ $members->count() === 1 ? 'participante' : 'participantes' }}</p>
        </div>

        <div class="rounded-xl border border-zinc-800 bg-slate-900 overflow-hidden">
            <div class="divide-y divide-zinc-800">
                @foreach ($members as $member)
                    <div class="flex items-center gap-4 px-5 py-3.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#C9920A]/10 text-sm font-bold text-[#C9920A]">
                            {{ strtoupper(substr($member->username, 0, 1)) }}
                        </div>
                        <span class="flex-1 text-sm font-semibold text-white">{{ $member->username }}</span>
                        @if ($member->id === $group->owner_id)
                            <span class="rounded-full bg-[#C9920A]/10 px-2.5 py-0.5 text-xs font-semibold text-[#C9920A]">Dono</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-layouts::app>
