<x-site-layout>
    {{-- Main Section --}}
    <section class="max-w-5xl mx-auto px-6 py-10 space-y-8">

        <h1 class="text-4xl font-extrabold text-gray-100 tracking-tight mb-8">
            All Hosts
        </h1>

        <div class="flex flex-col gap-6">
            @forelse($hosts as $host)
                <div class="w-full bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl p-6 shadow-xl
                            hover:border-green-300/20 hover:bg-white/10 transition-all duration-200">

                    {{-- Host Header (IN der Schleife!) --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <h2 class="text-2xl font-bold text-gray-100">
                            {{ $host->name }}
                        </h2>

                        <div class="flex items-center gap-4">
                            {{-- ⭐ Durchschnitt (nimmt withAvg oder Methode als Fallback) --}}
                            @php
                                $avg = isset($host->hosted_reviews_avg_rating)
                                    ? round((float) $host->hosted_reviews_avg_rating, 1)
                                    : round((float) $host->averageHostRating(), 1);
                            @endphp
                            <span class="text-sm text-yellow-400 font-semibold">
                                ⭐ {{ number_format($avg, 1) }} / 5
                            </span>

                            {{-- Event Count --}}
                            @if($host->events && $host->events->count() > 0)
                                <span class="text-sm text-green-400 font-medium">
                                    {{ $host->events->count() }} {{ Str::plural('Event', $host->events->count()) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Events List --}}
                    <div class="mt-3">
                        @if($host->events && $host->events->count() > 0)
                            <ul class="space-y-2 text-gray-300 text-sm">
                                @foreach($host->events as $event)
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                        <a href="/events/{{ $event->id }}"
                                           class="hover:text-green-300 transition">
                                            {{ $event->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400 italic text-sm mt-1">
                                No events organized yet.
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl py-6">
                    No hosts found.
                </div>
            @endforelse
        </div>
    </section>

</x-site-layout>

