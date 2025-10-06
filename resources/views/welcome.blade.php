<x-site-layout>

    {{-- HEADER --}}
    <header class="w-full lg:max-w-5xl mx-auto mb-10 flex justify-between items-center px-6 py-4 bg-white/5 backdrop-blur-md rounded-xl shadow-lg border border-white/10">
        <h1 class="text-2xl font-extrabold text-gray-100 tracking-tight">networ<span class="text-green-400">X</span></h1>

        @if (Route::has('login'))
            <nav class="flex items-center gap-3 text-sm">
                @auth
                    <span class="text-gray-300">Welcome, {{ auth()->user()->name }}</span>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-1.5 rounded-lg text-gray-100 hover:text-green-400 transition">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-1.5 rounded-lg border border-white/20 text-gray-200 hover:bg-white/10 transition">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    {{-- EVENT GRID --}}
    <section class="max-w-6xl mx-auto px-6 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($events as $event)
            <div class="glass bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl p-5 hover:scale-[1.02] transition-transform shadow-xl">
                <h2 class="text-xl font-bold text-gray-100 mb-1">{{ $event->title }}</h2>
                <h3 class="italic text-sm text-gray-400 mb-3">by {{ $event->host->name }}</h3>
                <p class="text-gray-300 leading-relaxed">
                    {{ Str::limit($event->description ?? $event->content, 120) }}
                </p>
                <div class="mt-4 text-sm text-green-400">
                {{ \Carbon\Carbon::parse($event->starts_at)->format('d.m.Y H:i') }}
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-400">
                Noch keine Events vorhanden.
            </div>
        @endforelse
    </section>

    {{-- FOOTER / INFO BOX --}}
    <footer class="max-w-6xl mx-auto mt-12 px-6 py-6 bg-gradient-to-r from-green-400/10 to-green-200/5 border border-green-300/20 rounded-2xl shadow-lg text-center text-green-200">
        <p class="text-sm">
        </p>
    </footer>
</x-site-layout>
