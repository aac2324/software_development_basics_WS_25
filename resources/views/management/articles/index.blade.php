<x-site-layout>

    <h1 class="text-4xl font-bold">My Articles overview</h1>

    <x:message-block />

    @foreach($events as $event)
        <div>
            <a href="managament/events/{{$event->id}}">{{ $event->title }}</a>
            <a href="/management/events/{{$event->id}}/edit" class="underline p-2 bg-blue-100 text-blue-500 text-sm rounded">EDIT</a>
        </div>
    @endforeach

</x-site-layout>
