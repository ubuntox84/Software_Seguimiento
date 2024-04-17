<div x-data="{ profileShowHidden: {{ request()->routeIs('profile*') ? 'true' : 'false' }} }"
    class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-gray-200 lg:bg-gray-100 lg:pt-5 lg:pb-4">
    <div class="flex flex-shrink-0 items-center px-6">
        @if ($configuration)
            <img class="h-8 w-auto" src="{{ asset($configuration->logo_path) }}" alt="{{ $configuration->faculty->abbreviation?$configuration->faculty->abbreviation:'Facultad' }}">
        @else
            
        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=purple&shade=500" alt="Your Company">
        @endif
    </div>
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="mt-5 flex h-0 flex-1 flex-col overflow-y-auto pt-1">
        <!-- User account dropdown -->
        <div class="relative inline-block px-3 text-left">
            <div>
                <button @click="profileShowHidden=!profileShowHidden" type="button"
                    class="group w-full rounded-md bg-gray-100 px-3.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-100"
                    id="options-menu-button" aria-expanded="false" aria-haspopup="true">
                    <span class="flex w-full items-center justify-between">
                        <span class="flex min-w-0 items-center justify-between space-x-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" />
                            <span class="flex min-w-0 flex-1 flex-col">
                                <span class="truncate text-sm font-medium text-gray-900">
                                    {{ Auth::user()->name }}</span>
                                @foreach (Auth::user()->roles->pluck('name') as $name)
                                    <span class="truncate text-xs text-gray-500">
                                        @if ($name === 'admin')
                                            Administrador
                                        @elseif ($name === 'user')
                                            Usuario
                                        @elseif ($name === 'commission')
                                            Comisión
                                        @else
                                            Otro Rol
                                        @endif
                                    </span>
                                @endforeach
                            </span>
                        </span>
                        <!-- Heroicon name: mini/chevron-up-down -->
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>
            </div>


            <div x-cloak x-show="profileShowHidden" x-transition:enter="transition ease-out duration-200" @click.outside="profileShowHidden = false"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 left-0 z-10 mx-3 mt-1 origin-top divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="options-menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')"
                        class="text-gray-700  block px-4 py-2 text-sm">
                        {{ __('Ver Perfil') }}
                    </x-jet-responsive-nav-link>
                     @hasanyrole('commision|admin')
                     <x-jet-responsive-nav-link href="{{ route('configuration') }}" :active="request()->routeIs('configuration')"
                        class="text-gray-700  block px-4 py-2 text-sm">
                        {{ __('Configuración') }}
                    </x-jet-responsive-nav-link>
                                       
                   @endhasanyrole

                    {{-- <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                        id="options-menu-item-1">Settings</a>
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                        id="options-menu-item-2">Notifications</a> --}}
                </div>
                {{-- <div class="py-1" role="none">
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                        id="options-menu-item-3">Get desktop app</a>
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                        id="options-menu-item-4">Support</a>
                </div> --}}
                <div class="py-1" role="none">
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-jet-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
        <!-- Sidebar Search -->
        {{-- <div class="mt-5 px-3">
            <label for="search" class="sr-only">Search</label>
            <div class="relative mt-1 rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3" aria-hidden="true">
                    <!-- Heroicon name: mini/magnifying-glass -->
                    <svg class="mr-3 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" id="search"
                    class="block w-full rounded-md border-gray-300 pl-9 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Searchsss">
            </div>
        </div> --}}
        <!-- Navigation -->
        <nav class="mt-6 px-3">
            <div class="space-y-1">

                <x-jet-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    <x-icon.home />
                    {{ __('Inicio') }}
                </x-jet-responsive-nav-link>

                @hasanyrole('commision|admin')
                    <x-jet-responsive-nav-link href="{{ route('faculty') }}" :active="request()->routeIs('faculty')">
                        <x-icon.home-modern />
                        {{ __('Facultades') }}
                    </x-jet-responsive-nav-link>
                    {{-- <x-jet-responsive-nav-link href="{{ route('departments') }}"
                    :active="request()->routeIs('departments')">
                    <x-icon.building-office />
                    {{ __('Departamentos') }}
                </x-jet-responsive-nav-link> --}}
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                            <x-jet-responsive-nav-link href="{{ route('user') }}" :active="request()->routeIs('user')">
                                <x-icon.users-icon />
                                {{ __('Usuarios') }}
                            </x-jet-responsive-nav-link>
                        @endif
                    @endauth

                    <x-jet-responsive-nav-link href="{{ route('curriculas') }}" :active="request()->routeIs('curriculas')">
                        <x-icon.list-bullet />
                        {{ __('Currículas') }}
                    </x-jet-responsive-nav-link>


                    <x-jet-responsive-nav-link href="{{ route('course') }}" :active="request()->routeIs('course')">
                        <x-icon.book-open />
                        {{ __('Cursos') }}
                    </x-jet-responsive-nav-link>
                    {{-- @dump(request()->route()->getName())
                @json(request()->routeIs('petition*')) --}}
                   
                @endhasanyrole
                <div x-data="{ isOpen: {{ request()->routeIs('petition*') ? 'true' : 'false' }} }"
                    class="space-y-1 pl-1 block  pr-4 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition">
                    <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                    <button type="button" @click="isOpen = !isOpen"
                        class=" text-gray-600 hover:text-gray-800  hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300  group w-full flex items-center pl-2 pr-1 py-2 text-left  rounded-md  focus:ring-2 focus:ring-indigo-500"
                        aria-controls="sub-menu-1" aria-expanded="false">
                        <!-- Heroicon name: outline/users -->
                        <x-icon.users-icon />
                        <span class="flex-1 font-medium pl-1">{{ __('Trámites') }}</span>
                        <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->

                        <svg x-cloak
                            class="text-gray-400  h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400"
                            :class="isOpen ? 'text-gray-400 rotate-90' : 'text-gray-400'" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>

                    </button>
                    <!-- Expandable link section, show/hide based on state. -->
                    <div x-cloak x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="space-y-1 ml-2" id="sub-menu-1">
                        @role('user')
                            <x-jet-responsive-nav-link href="{{ route('petition-make') }}" class="text-sm"
                                :active="request()->routeIs('petition-make') || request()->routeIs('petition-form')">
                                <x-icon.document-plus />
                                {{ __('Realizar Solicitud') }}
                            </x-jet-responsive-nav-link>
                        
                            <x-jet-responsive-nav-link href="{{ route('petition-list') }}" class="text-sm"
                                :active="request()->routeIs('petition-list')">
                                <x-icon.document-plus />
                                {{ __('Mis Solicitudes') }}
                            </x-jet-responsive-nav-link>
                        @endrole
                        @role('commission')
                            <x-jet-responsive-nav-link href="{{ route('petition_process_list') }}" class="text-sm"
                                :active="request()->routeIs('petition_process_list')">
                                <x-icon.document-plus />
                                {{ __('Solicitudes') }}
                            </x-jet-responsive-nav-link>
                        @endrole

                    </div>

                </div>
                @hasanyrole('commission|admin')
                 <div x-data="{ isOpen: {{ request()->routeIs('setting*') ? 'true' : 'false' }} }"
                        class="space-y-1 pl-1 block  pr-4 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition">
                        <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                        <button type="button" @click="isOpen = !isOpen"
                            class=" text-gray-600 hover:text-gray-800  hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300  group w-full flex items-center pl-2 pr-1 py-2 text-left  rounded-md  focus:ring-2 focus:ring-indigo-500"
                            aria-controls="sub-menu-1" aria-expanded="false">
                            <!-- Heroicon name: outline/users -->
                            <x-icon.users-icon />
                            <span class="flex-1 font-medium pl-1">{{ __('Configuración') }}</span>
                            <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->

                            <svg x-cloak
                                class="text-gray-400  h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400"
                                :class="isOpen ? 'text-gray-400 rotate-90' : 'text-gray-400'" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>

                        </button>
                        <!-- Expandable link section, show/hide based on state. -->
                        <div x-cloak x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75 transform"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="space-y-1 ml-2" id="sub-menu-1">
                            <x-jet-responsive-nav-link href="{{ route('setting-make-petition') }}" class="text-sm"
                                :active="request()->routeIs('setting-make-petition')">
                                <x-icon.document-plus />
                                {{ __('Solicitud') }}
                            </x-jet-responsive-nav-link>

                        </div>

                    </div>
                    @endhasanyrole

            </div>




            {{-- <div class="mt-8">
                <!-- Secondary navigation -->
                <h3 class="px-3 text-sm font-medium text-gray-500" id="desktop-teams-headline">Teams</h3>
                <div class="mt-1 space-y-1" role="group" aria-labelledby="desktop-teams-headline">
                    <a href="#"
                        class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                        <span class="w-2.5 h-2.5 mr-4 bg-indigo-500 rounded-full" aria-hidden="true"></span>
                        <span class="truncate">Engineering</span>
                    </a>

                    <a href="#"
                        class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                        <span class="w-2.5 h-2.5 mr-4 bg-green-500 rounded-full" aria-hidden="true"></span>
                        <span class="truncate">Human Resources</span>
                    </a>

                    <a href="#"
                        class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                        <span class="w-2.5 h-2.5 mr-4 bg-yellow-500 rounded-full" aria-hidden="true"></span>
                        <span class="truncate">Customer Success</span>
                    </a>
                </div>
            </div> --}}
        </nav>

    </div>
</div>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
