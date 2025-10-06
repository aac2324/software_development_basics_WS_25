<x-site-layout>
    {{-- PAGE CONTAINER --}}
    <section class="max-w-4xl mx-auto px-6 py-10 space-y-8">

        {{-- FLASH / MESSAGES --}}
        <x:message-block />

        {{-- EVENT CARD (glassy, wie auf der Welcome) --}}
        <article class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl shadow-xl">
            {{-- Header: Titel + Aktionen --}}
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 px-6 pt-6">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-100 tracking-tight">
                    {{ $event->title }}
                </h1>

                @auth
                    @if($event->canEditOrDelete(auth()->user()))
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="/management/events/{{ $event->id }}/edit"
                               class="px-3 py-1.5 text-sm rounded-lg border border-white/20 text-gray-200 hover:bg-white/10 transition">
                                EDIT
                            </a>

                            <form action="/management/events/{{ $event->id }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 text-sm rounded-lg bg-red-500/10 text-red-200 border border-red-300/30 hover:bg-red-500/20 transition">
                                    DELETE
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="text-xs text-gray-400 mt-1">If something is wrong.....</span>
                    @endif
                @endauth
            </div>

            {{-- Meta --}}
            <div class="px-6 mt-3">
                <p class="text-sm text-gray-300">
                    by our reporter:
                    <span class="text-green-300 font-medium">{{ $event->host?->name }}</span>
                </p>
            </div>

            {{-- Content --}}
            <div class="px-6 pb-6 mt-4">
                <div class="prose prose-invert prose-sm md:prose-base max-w-none text-gray-200 leading-relaxed">
                    {{ $event->content }}
                </div>
            </div>
        </article>

        {{-- REVIEWS --}}
        <section class="space-y-5">
            <h2 class="text-2xl font-bold text-gray-100">Reviews</h2>

            {{-- Liste der Reviews (kleine Glass-Boxen) --}}
            <div class="space-y-3">
                @forelse($event->reviews as $review)
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl px-5 py-4 shadow-md">
                        <p class="text-gray-200 leading-relaxed">
                            {{ $review->content }}
                        </p>
                    </div>
                @empty
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl px-5 py-4 text-gray-400 text-sm">
                        No Reviews available yet.
                    </div>
                @endforelse
            </div>

            {{-- Neues Review (nur für Auth) --}}
            @auth
                <form action="/reviews" method="post" class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-md space-y-3">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}"/>

                    <label for="content" class="block text-sm font-medium text-gray-300">New review</label>

                    <textarea id="content" name="content"
                              class="w-full min-h-[140px] resize-y rounded-xl bg-white/80 text-zinc-900 placeholder-zinc-500 p-3 shadow-inner outline-none focus:ring-2 focus:ring-green-400/60"
                              placeholder="Schreib dein Feedback…">{{ old('content') }}</textarea>

                    @error('content')
                        <p class="text-red-400 text-xs">{{ $message }}</p>
                    @enderror

                    <div class="pt-1">
                        <button class="inline-flex items-center gap-2 bg-green-500/90 hover:bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-lg transition"
                                type="submit">
                            Put review
                        </button>
                    </div>
                </form>
            @endauth
        </section>
    </section>
</x-site-layout>
