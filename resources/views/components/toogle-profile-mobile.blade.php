<div>
        <!-- Profile dropdown -->
        <div class="relative ml-3"  x-data="{ ProfileOpenMobile: false }">
            <div>
                <button @click="ProfileOpenMobile = !ProfileOpenMobile" type="button"
                    class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full"
                        src="{{ Auth::user()->profile_photo_url }}"
                        alt="">
                </button>
            </div>
            <div x-show="ProfileOpenMobile" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}"
                        :active="request()->routeIs('profile.show')" class="text-gray-700  block px-4 py-2 text-sm">
                        {{ __('Ver Perfil') }}
                    </x-jet-responsive-nav-link>
                    @hasanyrole('commision|admin')
                    <x-jet-responsive-nav-link href="{{ route('configuration') }}"
                        :active="request()->routeIs('configuration')" class="text-gray-700  block px-4 py-2 text-sm">
                        {{ __('Configuración') }}
                    </x-jet-responsive-nav-link>

                    @endhasanyrole
                </div>
                {{-- <div class="py-1" role="none">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                        id="user-menu-item-3">Get desktop app</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                        id="user-menu-item-4">Support</a>
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
    
</div>