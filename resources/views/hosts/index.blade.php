<x-site-layout>
    <ul class="list-disc pl-4">
        @foreach($hosts as $host)
            <li>{{$host->name}}</li>
        @endforeach

    </ul>
</x-site-layout>
