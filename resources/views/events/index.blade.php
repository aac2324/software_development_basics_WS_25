<x-site-layout>

            <h1 class="text-4xl font-bold">All Events</h1>

            @foreach($events as $event)
                <div>
                    <a href="/events/{{$event->id}}">{{ $event->title }}</a>
                </div>
            @endforeach

</x-site-layout>
