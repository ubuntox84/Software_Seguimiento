<div class="relative z-40 lg:hidden" role="dialog" aria-modal="true">
    <!--
          Off-canvas menu backdrop, show/hide based on off-canvas menu state.

          Entering: "transition-opacity ease-linear duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "transition-opacity ease-linear duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
    <div x-show="mobileShowHidden" class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

    <div x-show="mobileShowHidden" class="fixed inset-0 z-40 flex">
        <!--
          Off-canvas menu, show/hide based on off-canvas menu state.

          Entering: "transition ease-in-out duration-300 transform"
            From: "-translate-x-full"
            To: "translate-x-0"
          Leaving: "transition ease-in-out duration-300 transform"
            From: "translate-x-0"
            To: "-translate-x-full"
        -->
        <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">
            <!--
            Close button, show/hide based on off-canvas menu state.

            Entering: "ease-in-out duration-300"
              From: "opacity-0"
              To: "opacity-100"
            Leaving: "ease-in-out duration-300"
              From: "opacity-100"
              To: "opacity-0"
          -->
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="mobileShowHidden=!mobileShowHidden" type="button"
                    class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <!-- Heroicon name: outline/x-mark -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>

            <div class="flex flex-shrink-0 items-center px-4">
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=purple&shade=500"
                    alt="Your Company">
            </div>
            <div class="mt-5 h-0 flex-1 overflow-y-auto">
                <nav class="px-2">
                    <div class="space-y-1">

                        <x-jet-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                            <x-icon.home />
                            {{ __('Inicio') }}
                        </x-jet-responsive-nav-link>

                        @hasanyrole('commision|admin')
                        <x-jet-responsive-nav-link href="{{ route('faculty') }}"
                            :active="request()->routeIs('faculty')">
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

                        <x-jet-responsive-nav-link href="{{ route('curriculas') }}"
                            :active="request()->routeIs('curriculas')">
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
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>

                            </button>
                            <!-- Expandable link section, show/hide based on state. -->
                            <div x-cloak x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95" class="space-y-1 ml-2" id="sub-menu-1">
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
                                    :class="isOpen ? 'text-gray-400 rotate-90' : 'text-gray-400'" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>

                            </button>
                            <!-- Expandable link section, show/hide based on state. -->
                            <div x-cloak x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95" class="space-y-1 ml-2" id="sub-menu-1">
                                <x-jet-responsive-nav-link href="{{ route('setting-make-petition') }}" class="text-sm"
                                    :active="request()->routeIs('setting-make-petition')">
                                    <x-icon.document-plus />
                                    {{ __('Solicitud') }}
                                </x-jet-responsive-nav-link>

                            </div>

                        </div>
                        @endhasanyrole

                    </div>

                </nav>
            </div>
        </div>

        <div class="w-14 flex-shrink-0" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
    </div>
</div>