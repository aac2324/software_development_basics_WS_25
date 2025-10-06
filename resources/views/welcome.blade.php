<x-site-layout>

        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        You are logged in. Welcome {{ auth()->user()->name }}
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <div class="grid grid-cols-2 gap-6">
            @foreach($events as $event)
                <div>
                    <h2 class="font-bold">{{$event->title}}</h2>
                    <h3 class="italic">by {{$event->author->name}}</h3>
                    {{$event->content}}
                </div>
            @endforeach
        </div>


        <div class="max-w-6xl mx-auto px-4 py-4 bg-green-50 border-xl shadow-2xl mb-4 text-green-700">
            This is test content only
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif

</x-site-layout>
