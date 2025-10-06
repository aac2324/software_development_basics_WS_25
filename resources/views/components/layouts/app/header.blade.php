<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')

        <!-- Visible Glass-Style + Page-Gradient (nur Optik, keine JS/Logik) -->
        <style>
          /* Page background: subtiler radialer Verlauf,
             damit der Glass-Header sofort sichtbar wirkt. */
          .ng-page-bg {
            background:
              radial-gradient(1200px 600px at 10% -10%, rgba(224,163,255,0.10), transparent 60%),
              radial-gradient(900px 500px at 90% -20%, rgba(124,58,237,0.10), transparent 60%);
          }
          @media (prefers-color-scheme: dark) {
            .ng-page-bg {
              background:
                radial-gradient(1200px 600px at 10% -10%, rgba(224,163,255,0.12), transparent 60%),
                radial-gradient(900px 500px at 90% -20%, rgba(124,58,237,0.12), transparent 60%);
            }
          }

          /* Glass Header – deutlichere Optik */
          .ng-glass {
            background: rgba(20,20,20,0.45);            /* dunkler Grundtint */
            -webkit-backdrop-filter: blur(18px) saturate(120%);
            backdrop-filter: blur(18px) saturate(120%);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 16px;
          }
          .ng-glass.light {
            background: rgba(255,255,255,0.55);          /* für Light Mode */
            border-color: rgba(0,0,0,0.08);
          }
          .ng-glass.scrolled {
            background: rgba(20,20,20,0.60);
          }
          .ng-glass.light.scrolled {
            background: rgba(255,255,255,0.72);
          }

          /* Links / Nav Items */
          .ng-link { transition: color .18s ease, opacity .18s ease; opacity: .9; }
          .ng-link:hover { opacity: 1; color: #e0a3ff; }

          /* Aktives Nav-Item: dezente Unterstreichung (sichtbar) */
          .ng-active {
            position: relative;
          }
          .ng-active::after {
            content: "";
            position: absolute;
            left: 0.5rem; right: 0.5rem; bottom: -8px;
            height: 2px;
            background: linear-gradient(90deg, #8e72f4, #e0a3ff);
            border-radius: 2px;
          }

          /* Konsistente Icon-Button-Höhe */
          .ng-icon { height: 2.25rem; } /* ~ h-9 */
        </style>
    </head>

    <!-- Füge der <body> den subtilen Gradient hinzu -->
    <body class="min-h-screen bg-white dark:bg-zinc-800 ng-page-bg">
        <!-- Tipp: Wenn du Scroll-Feedback willst, kannst du Alpine nutzen und 'scrolled' togglen.
             Die Klasse unten funktioniert aber auch ohne das Scroll-Feedback. -->
        <flux:header 
            container
            class="sticky top-2 z-50 mx-2 lg:mx-4 border bg-transparent
                   px-2 lg:px-3 py-1.5 rounded-xl shadow-md transition-colors
                   ng-glass light:ng-glass light">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                <x-app-logo />
                <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-100 hidden sm:inline ng-link">
                    {{ __('Dashboard') }}
                </span>
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item
                    icon="layout-grid"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    class="ng-link px-2 {{ request()->routeIs('dashboard') ? 'ng-active' : '' }}"
                    wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse">
                <flux:tooltip :content="__('Search')" position="bottom">
                    <flux:navbar.item class="ng-icon [&>div>svg]:size-5 ng-link"
                                      icon="magnifying-glass" href="#" :label="__('Search')" />
                </flux:tooltip>

                <flux:tooltip :content="__('Repository')" position="bottom">
                    <flux:navbar.item
                        class="ng-icon max-lg:hidden [&>div>svg]:size-5 ng-link"
                        icon="folder-git-2"
                        href="https://github.com/laravel/livewire-starter-kit"
                        target="_blank"
                        :label="__('Repository')"
                    />
                </flux:tooltip>

                <flux:tooltip :content="__('Documentation')" position="bottom">
                    <flux:navbar.item
                        class="ng-icon max-lg:hidden [&>div>svg]:size-5 ng-link"
                        icon="book-open-text"
                        href="https://laravel.com/docs/starter-kits#livewire"
                        target="_blank"
                        label="Documentation"
                    />
                </flux:tooltip>
            </flux:navbar>

            <!-- Desktop User Menu (Funktion & Struktur unverändert) -->
            <flux:dropdown position="top" align="end">
                <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Mobile Menu (unverändert, nur Optik vom Seiten-Gradient profitiert) -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')">
                    <flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                      {{ __('Dashboard') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
