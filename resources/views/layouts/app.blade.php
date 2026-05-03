<x-layouts::app.sidebar :title="$title ?? null">
    <main class="flex items-start justify-center bg-slate-950 px-4 py-12">
        <div class="w-full">
            {{ $slot }}
        </div>
    </main>
</x-layouts::app.sidebar>
