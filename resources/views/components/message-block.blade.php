@if(session()->has('specialMessage'))
    <div class="bg-green-50 p-2 border border-green-500 text-black rounded mb-4">
        {{ session()->get('specialMessage') }}
    </div>
@endif
