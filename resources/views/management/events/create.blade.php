<x-site-layout>
    <section class="max-w-3xl mx-auto px-6 py-10 space-y-6">
        <h1 class="text-3xl font-bold text-gray-100">Create a new Event</h1>

        <form action="/management/events" method="post"
              class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl p-6 shadow-xl space-y-5">
            @csrf

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300">Title *</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}"
                       class="w-full rounded-lg bg-white/80 text-zinc-900 p-2 focus:ring-2 focus:ring-green-400/50"
                       placeholder="Event title">
                @error('title')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description / Content --}}
            <div>
                <label for="content" class="block text-sm font-medium text-gray-300">Description *</label>
                <textarea id="content" name="content" rows="6"
                          class="w-full rounded-lg bg-white/80 text-zinc-900 p-3 focus:ring-2 focus:ring-green-400/50"
                          placeholder="Describe what your event is about...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Optional: Start Date (exists in your events listing) --}}
            <div>
                <label for="starts_at" class="block text-sm font-medium text-gray-300">Start Date & Time</label>
                <input id="starts_at" name="starts_at" type="datetime-local" value="{{ old('starts_at') }}"
                       class="w-full rounded-lg bg-white/80 text-zinc-900 p-2 focus:ring-2 focus:ring-green-400/50">
                @error('starts_at')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <a href="{{ url()->previous() }}"
                   class="px-4 py-2 rounded-lg border border-white/20 text-gray-200 hover:bg-white/10 transition">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-green-500 hover:bg-green-400 text-white rounded-lg font-semibold transition">
                    Create Event
                </button>
            </div>
        </form>
    </section>
</x-site-layout>
