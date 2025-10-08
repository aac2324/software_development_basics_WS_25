<x-site-layout>
    <div class="max-w-5xl mx-auto px-6 py-12 text-white">

        {{-- Hero --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-3">
                Welcome to <span class="text-green-400">networX</span>
            </h1>
            <p class="text-white/70 max-w-2xl mx-auto leading-relaxed">
                The student event hub — discover, rate, and revisit experiences across your community.
            </p>
        </div>

        {{-- Upcoming Events --}}
        <section class="mb-14">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-2xl font-semibold">Upcoming Events</h2>
                <a href="{{ route('events.index') }}" class="text-green-400 hover:text-green-300 transition">
                    View all →
                </a>
            </div>

            @forelse($events ?? [] as $event)
                <a href="{{ route('events.show', $event->id) }}"
                   class="block p-5 mb-4 rounded-2xl border border-white/10 bg-white/5 dark:bg-zinc-800/60
                          backdrop-blur-md hover:border-green-400/30 hover:scale-[1.01] transition">
                    <h3 class="text-lg font-semibold">{{ $event->title }}</h3>
                    <p class="text-sm text-white/60">
                        by {{ $event->host?->name ?? 'Unknown host' }}
                    </p>

                    <p class="mt-2 text-sm text-white/80 leading-relaxed">
                        {{ Str::limit($event->description ?? $event->content ?? 'No description available', 120) }}
                    </p>

                    @if(!empty($event->starts_at))
                        <p class="mt-3 text-xs text-green-400">
                            📅 {{ \Carbon\Carbon::parse($event->starts_at)->format('d M Y, H:i') }}
                        </p>
                    @endif
                </a>
            @empty
                <p class="text-sm text-white/60">No upcoming events yet.</p>
            @endforelse
        </section>

        {{-- Hosts --}}
        <section>
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-2xl font-semibold">Featured Hosts</h2>
                <a href="{{ route('hosts.index') }}" class="text-green-400 hover:text-green-300 transition">
                    See all →
                </a>
            </div>

            @forelse($hosts ?? [] as $host)
                <div class="p-5 mb-4 rounded-2xl border border-white/10 bg-white/5 dark:bg-zinc-800/60
                            backdrop-blur-md hover:border-green-400/30 transition">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">{{ $host->name }}</h3>
                        <span class="text-xs text-green-400">
                            {{ $host->events->count() }} events
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-white/60">No hosts found yet.</p>
            @endforelse
        </section>

    </div>
</x-site-layout>
