<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 h-screen fixed w-64">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-600">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="mt-4 flex flex-col">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center px-6 py-3">
            <x-heroicon-o-home class="w-5 h-5 mr-3" />
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')" class="flex items-center px-6 py-3">
            <x-heroicon-o-bell class="w-5 h-5 mr-3" />
            {{ __('Notifications') }}
        </x-nav-link>

        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="flex items-center px-6 py-3">
            <x-heroicon-o-user class="w-5 h-5 mr-3" />
            {{ __('Profile') }}
        </x-nav-link>
    </div>

    <!-- Settings / Logout -->
    <div class="mt-auto border-t border-gray-200 dark:border-gray-600 p-4">
        <div class="mb-2 text-gray-800 dark:text-gray-200 font-medium">{{ Auth::user()->name }}</div>
        <div class="mb-4 text-gray-500 dark:text-gray-400 text-sm">{{ Auth::user()->email }}</div>

        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <button class="flex items-center w-full px-4 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none">
                    <x-heroicon-o-user class="w-5 h-5 mr-2" />
                    {{ __('Profile') }}
                    <svg class="ml-auto h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                                 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 
                                 010-1.414z"
                              clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    <x-heroicon-o-user class="w-5 h-5 mr-1 inline" />
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-1 inline" />
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>

<!-- Main content wrapper -->
<div class="ml-64 p-6">
    <!-- Your main content goes here -->
</div>
<nav x-data="{ open: true }" class="fixed h-screen bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 transition-all duration-300" 
     :class="open ? 'w-64' : 'w-20'">
    <!-- Toggle Button -->
    <div class="flex justify-end p-2 border-b border-gray-200 dark:border-gray-600">
        <button @click="open = !open" class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none">
            <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-600">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="mt-4 flex flex-col">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                    class="flex items-center px-4 py-3 transition-all duration-300">
            <x-heroicon-o-home class="w-5 h-5" />
            <span x-show="open" class="ml-3 transition-all duration-300">{{ __('Dashboard') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')" 
                    class="flex items-center px-4 py-3 transition-all duration-300">
            <x-heroicon-o-bell class="w-5 h-5" />
            <span x-show="open" class="ml-3 transition-all duration-300">{{ __('Notifications') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" 
                    class="flex items-center px-4 py-3 transition-all duration-300">
            <x-heroicon-o-user class="w-5 h-5" />
            <span x-show="open" class="ml-3 transition-all duration-300">{{ __('Profile') }}</span>
        </x-nav-link>
    </div>

    <!-- Settings / Logout -->
    <div class="mt-auto border-t border-gray-200 dark:border-gray-600 p-4">
        <div x-show="open" class="mb-2 text-gray-800 dark:text-gray-200 font-medium transition-all duration-300">{{ Auth::user()->name }}</div>
        <div x-show="open" class="mb-4 text-gray-500 dark:text-gray-400 text-sm transition-all duration-300">{{ Auth::user()->email }}</div>

        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <button class="flex items-center w-full px-2 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none">
                    <x-heroicon-o-user class="w-5 h-5" />
                    <span x-show="open" class="ml-2 transition-all duration-300">{{ __('Profile') }}</span>
                    <svg x-show="open" class="ml-auto h-4 w-4 fill-current transition-all duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                                 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 
                                 010-1.414z"
                              clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    <x-heroicon-o-user class="w-5 h-5 mr-1 inline" />
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-1 inline" />
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>

<!-- Main content wrapper -->
<div :class="open ? 'ml-64' : 'ml-20'" class="transition-all duration-300 p-6">
    <!-- Your main content goes here -->
</div>
