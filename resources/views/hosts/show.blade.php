<x-site-layout>
    <h1 class="text-4xl font-bold">{{$host->name}}</h1>

    <h2 class="text-2xl font-bold">List of events</h2>

    @foreach($host->events as $event)
        {{ $event->title }}<br/>
    @endforeach
</x-site-layout>
