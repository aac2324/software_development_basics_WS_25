<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>All Events</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        /* Simple networX style */
        body {
            background: radial-gradient(circle at 20% 20%, #12121c, #0c0c12 70%);
            color: #fff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Header Glass Look */
        .nx-header {
            background: rgba(255, 255, 255, 0.06);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
        }

        /* Hover Links */
        .nx-link {
            color: #d0d0e0;
            transition: color .2s ease;
        }
        .nx-link:hover {
            color: #8e72f4;
        }

        /* Auth buttons / text */
        .nx-auth form {
            display: inline;
        }

        /* Footer */
        .nx-footer {
            background: rgba(255, 255, 255, 0.05);
            -webkit-backdrop-filter: blur(6px);
            backdrop-filter: blur(6px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col"><!-- ⬅️ ADDED: min-h-screen flex flex-col -->
    <header class="nx-header w-full h-14">>
       <div class="max-w-6xl w-full mx-auto px-6 h-full flex justify-between items-center">
         <div class="font-semibold tracking-wide text-[#e4ddff]">
            networX Event Review Site
        </div>

        <nav class="space-x-4">
            <a href="/events" class="nx-link">All Events</a>
            <a href="/hosts" class="nx-link">All Hosts</a>
        </nav>

        <div class="nx-auth text-xs md:text-sm text-zinc-300 flex items-center space-x-2">
            @auth
                <span class="text-zinc-200">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="post" class="inline">@csrf
                    <button type="submit" class="nx-link underline underline-offset-2">Logout</button>
                </form>
            @else
                <span class="text-zinc-400">Are you logged in?</span>
            @endauth
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-6 bg-white/5 rounded-2xl shadow-inner">
        {{ $slot }}
    </main>

    <footer class="nx-footer text-zinc-300 mt-16 py-6">
        <div class="max-w-6xl mx-auto px-6">
            This project was created by <span class="text-[#8e72f4] font-semibold">Ana Goldbeck</span>,
            Master’s student at CODE University of Applied Sciences, for the Software Engineering Course (Fall 2025).
        </div>
    </footer>
</body>
</html>
