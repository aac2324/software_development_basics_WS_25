<x-site-layout>

    <h1 class="text-4xl font-bold">{{$event->title}}</h1>

    <x:message-block />

    @auth
        @if($event->canEditOrDelete(auth()->user()))
            <a href="/management/events/{{$event->id}}/edit" class="underline">EDIT</a>

            <form action="/management/events/{{$event->id}}" method="post">
                @method('DELETE')
                @csrf
                <button  class="underline">DELETE</button>
            </form>
        @else
            <span class="text-xs">If something is wrong.....</span>
        @endif
    @endauth


    <div class="mb-2 text-blue-800">by our reporter: {{$event->host->name}}.</div>
    <div>
        {{$event->content}}
    </div>

    <h2 class="text-2xl font-bold mt-4">Reviews</h2>
    <div>
        @foreach($event->reviews as $review)
            <div>
                {{$review->content}}
            </div>
        @endforeach

        @auth
        <form action="/reviews" method="post" class="bg-gray-200 p-4">
            @csrf

            <input type="hidden" name="event_id" value="{{$event->id}}"/>
            <div>
                <label for="content">New review</label><br/>
                <textarea name="content" class="bg-gray-50 p-2 w-1/2">{{old('content')}}</textarea><br/>
                @error('content')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <br/><br/>
            <button class="bg-blue-500 p-1 uppercase" type="submit">Put review</button>
        </form>
        @endauth

    </div>

</x-site-layout>
