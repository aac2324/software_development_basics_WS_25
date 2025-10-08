<x-site-layout>

    {{-- PAGE CONTAINER --}}
    <section class="max-w-6xl mx-auto px-6 py-10 space-y-8">

        {{-- TITLE --}}
        <h1 class="text-4xl font-extrabold text-gray-100 tracking-tight mb-8">
            All Events
        </h1>

        {{-- EVENTS GRID --}}
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($events as $event)
                <a href="/events/{{ $event->id }}"
                   class="block bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl p-6 shadow-xl
                          hover:scale-[1.02] hover:border-green-300/20 transition-transform">
                    
                    {{-- Titel + ⭐ Rating --}}
                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-xl font-bold text-gray-100">
                            {{ $event->title }}
                        </h2>
                        <span class="text-sm text-yellow-400 font-semibold">
                            ⭐ {{ number_format($event->averageRating(), 1) }} / 5
                        </span>
                    </div>

                    {{-- Host --}}
                    <p class="italic text-sm text-gray-400 mb-3">
                        by {{ $event->host?->name ?? 'Unknown host' }}
                    </p>

                    {{-- Kurzbeschreibung / Vorschau --}}
                    <p class="text-gray-300 leading-relaxed">
                        {{ Str::limit($event->description ?? $event->content, 120) }}
                    </p>

                    {{-- Datum, falls vorhanden --}}
                    @if(!empty($event->starts_at))
                        <div class="mt-4 text-sm text-green-400 font-medium">
                            {{ \Carbon\Carbon::parse($event->starts_at)->format('d.m.Y H:i') }}
                        </div>
                    @endif
                </a>
            @empty
                <div class="col-span-full text-center text-gray-400">
                    Noch keine Events vorhanden.
                </div>
            @endforelse
        </div>
    </section>

</x-site-layout>
