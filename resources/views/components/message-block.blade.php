@if(session()->has('specialMessage'))
    <div class="bg-green-50 p-3 border border-green-400 rounded-lg text-sm text-green-700 mb-4">
        {{ session('specialMessage') }}
    </div>
@endif
