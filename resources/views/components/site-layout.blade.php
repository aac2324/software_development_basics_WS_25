<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>All Reviews</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="">
<header class="max-w-6xl mx-auto bg-blue-500 text-xl text-white mb-4 flex items-center h-12">
    <div class="mr-10">
        networX Event Review Site
    </div>
    <div>
        <a href="/events">All Events</a>
        |
        <a href="/hosts">All Hosts</a>
    </div>
    <div class="ml-24">
        @auth
            {{ auth()->user()->name }} |
            <form action="{{route('logout')}}" method="post">@csrf <button type="submit">Logout</button></form>
        @else
            login button
        @endauth
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 py-4">

    {{$slot}}

</main>


<footer class="bg-blue-900 text-white mt-12 min-h-20">

    <div class="max-w-6xl mx-auto px-20 py-4">
        This is a project by Ana Goldbeck, Master Student at CODE University of Applied Sciences of Applied Sciences for the Software Engineering Course - Fall 2025.
    </div>
</footer>
</body>

</html>
