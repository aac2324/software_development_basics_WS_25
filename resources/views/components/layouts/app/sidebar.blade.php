<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
  <head>
    @include('partials.head')

    <!-- Sidebar Glass Look (nur CSS, keinerlei Funktionsänderung) -->
    <style>
      /* Dezent sichtbarer Hintergrundverlauf, damit Glass sichtbar wird */
      .ng-page-bg {
        background:
          radial-gradient(900px 450px at -10% 5%, rgba(224,163,255,0.10), transparent 55%),
          radial-gradient(800px 400px at 110% -10%, rgba(124,58,237,0.10), transparent 60%);
      }
      @media (prefers-color-scheme: dark) {
        .ng-page-bg {
          background:
            radial-gradient(900px 450px at -10% 5%, rgba(224,163,255,0.12), transparent 55%),
            radial-gradient(800px 400px at 110% -10%, rgba(124,58,237,0.12), transparent 60%);
        }
      }

      /* Sidebar: Glass + Blur */
      .ng-sidebar {
        background: rgba(255,255,255,0.55);
        -webkit-backdrop-filter: blur(18px) saturate(120%);
        backdrop-filter: blur(18px) saturate(120%);
        border-right: 1px solid rgba(0,0,0,0.08);
      }
      @media (prefers-color-scheme: dark) {
        .ng-sidebar {
          background: rgba(20,20,20,0.45);
          border-right-color: rgba(255,255,255,0.14);
        }
      }

      /* Nav-Links: ruhige Hover-States */
      .ng-link { transition: color .18s ease, opacity .18s ease, background-color .18s ease; opacity: .92; }
      .ng-link:hover { opacity: 1; color: #e0a3ff; }

      /* Aktiver Eintrag: linke farbige Leiste */
      .ng-active {
        position: relative;
      }
      .ng-active::before {
        content: "";
        position: absolute;
        left: 0;
        top: 8px;
        bottom: 8px;
        width: 3px;
        border-radius: 2px;
        background: linear-gradient(180deg, #8e72f4, #e0a3ff);
      }

      /* Leicht kompaktere List-Items */
      .ng-item { height: 2.5rem; } /* ~ h-10 */
    </style>
  </head>

  <body class="min-h-screen bg-white dark:bg-zinc-800 ng-page-bg">
    <flux:sidebar
      sticky
      stashable
      class="ng-sidebar rounded-r-2xl shadow-sm"
    >
      <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

      <a href="{{ route('dashboard') }}" class="me-5 mt-1 mb-2 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo />
      </a>

      <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Platform')" class="grid">
          <flux:navlist.item
            icon="home"
            :href="route('dashboard')"
            :current="request()->routeIs('dashboard')"
            class="ng-item ng-link {{ request()->routeIs('dashboard') ? 'ng-active' : '' }}"
            wire:navigate
          >
            {{ __('Dashboard') }}
          </flux:navlist.item>
        </flux:navlist.group>
      </flux:navlist>

      <flux:spacer />

      <flux:navlist variant="outline">
        <flux:navlist.item
          icon="folder-git-2"
          href="https://github.com/laravel/livewire-starter-kit"
          target="_blank"
          class="ng-item ng-link"
        >
          {{ __('Repository') }}
        </flux:navlist.item>

        <flux:navlist.item
          icon="book-open-text"
          href="https://laravel.com/docs/starter-kits#livewire"
          target="_blank"
          class="ng-item ng-link"
        >
          {{ __('Documentation') }}
        </flux:navlist.item>
      </flux:navlist>

      <!-- Desktop User Menu (Struktur & Funktion unverändert) -->
      <flux:dropdown class="hidden lg:block" position="bottom" align="start">
        <flux:profile
          :name="auth()->user()->name"
          :initials="auth()->user()->initials()"
          icon:trailing="chevrons-up-down"
        />

        <flux:menu class="w-[220px]">
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
                  <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                </div>
              </div>
            </div>
          </flux:menu.radio.group>

          <flux:menu.separator />

          <flux:menu.radio.group>
            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
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
    </flux:sidebar>

    <!-- Mobile User Menu (lassen wir funktional identisch) -->
    <flux:header class="lg:hidden">
      <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

      <flux:spacer />

      <flux:dropdown position="top" align="end">
        <flux:profile
          :initials="auth()->user()->initials()"
          icon-trailing="chevron-down"
        />

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
                  <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                </div>
              </div>
            </div>
          </flux:menu.radio.group>

          <flux:menu.separator />

          <flux:menu.radio.group>
            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
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

    {{ $slot }}

    @fluxScripts
  </body>
</html>

