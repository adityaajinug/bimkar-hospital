<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <!-- Navigation Links -->
                <div class="hidden sm:flex">
                    <x-nav-link :href="route('home.index')" :active="request()->routeIs('home.index')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>

                <div x-data="{ open: false }" class="relative sm:flex"> 
                    <!-- Dropdown Trigger -->
                    <button @click="open = !open" class="hidden sm:flex items-center py-2 text-sm font-medium hover:text-gray-700 text-gray-500 bg-white rounded-lg focus:outline-none focus:ring-0 focus:text-gray-700">
                        {{ __('Master Data') }}
                        <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Dropdown Menu -->
                    <div 
                        x-show="open" 
                        @click.outside="open = false" 
                        x-transition 
                        x-cloak
                        class="absolute right-0 z-20 top-12 w-48 py-2 mt-2 bg-white border rounded-lg shadow-md flex flex-col gap-2 px-2"
                    >
                        <x-nav-link :href="route('pasien.index')" :active="request()->routeIs('pasien.index')" class="block py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Pasien') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dokter.index')" :active="request()->routeIs('dokter.index')" class="block py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Dokter') }}
                        </x-nav-link>
                    </div>
                </div>

                <div class="hidden sm:flex">
                    <x-nav-link :href="route('periksa.index')" :active="request()->routeIs('periksa.index')">
                        {{ __('Periksa') }}
                    </x-nav-link>
                </div>
                
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home.index')" :active="request()->routeIs('home.index')">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>

        <div x-data="{ open: false }" class="relative sm:ms-10 sm:flex">
            <!-- Dropdown Trigger -->
            <button @click="open = !open" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg focus:outline-none focus:ring-0">
                {{ __('Master Data') }}
                <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        
            <!-- Dropdown Menu -->
            <div 
                x-show="open" 
                @click.outside="open = false" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                x-cloak
                class="absolute left-4 z-20 top-8 w-48 py-2 mt-2 bg-white border rounded-lg shadow-md flex-col gap-2 px-2"
                :class="open ? 'flex' : 'hidden'"
            >
                <x-responsive-nav-link :href="route('pasien.index')" :active="request()->routeIs('pasien.index')" class="block py-2 text-sm text-gray-700 hover:bg-gray-100">
                    {{ __('Pasien') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dokter.index')" :active="request()->routeIs('dokter.index')" class="block py-2 text-sm text-gray-700 hover:bg-gray-100">
                    {{ __('Dokter') }}
                </x-responsive-nav-link>
            </div>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('periksa.index')" :active="request()->routeIs('periksa.index')">
                {{ __('Periksa') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
