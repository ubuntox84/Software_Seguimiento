<div class="flex flex-col lg:pl-64">
    <!-- Search header -->
    <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white lg:hidden">
      <!-- Sidebar toggle, controls the 'sidebarOpen' sidebar state. -->
      <button type="button" class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <!-- Heroicon name: outline/bars-3-center-left -->
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
        </svg>
      </button>
      <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex flex-1">
          <form class="flex w-full md:ml-0" action="#" method="GET">
            <label for="search-field" class="sr-only">Search</label>
            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
              <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">
                <!-- Heroicon name: mini/magnifying-glass -->
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
              </div>
              <input id="search-field" name="search-field" class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm" placeholder="Search" type="search">
            </div>
          </form>
        </div>
        <div class="flex items-center">
          <!-- Profile dropdown -->
          <div class="relative ml-3">
            <div>
              <button type="button" class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
              </button>
            </div>

            <!--
              Dropdown menu, show/hide based on menu state.

              Entering: "transition ease-out duration-100"
                From: "transform opacity-0 scale-95"
                To: "transform opacity-100 scale-100"
              Leaving: "transition ease-in duration-75"
                From: "transform opacity-100 scale-100"
                To: "transform opacity-0 scale-95"
            -->
            <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <div class="py-1" role="none">
                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-0">View profile</a>
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-2">Notifications</a>
              </div>
              <div class="py-1" role="none">
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-3">Get desktop app</a>
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-4">Support</a>
              </div>
              <div class="py-1" role="none">
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-5">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <main class="flex-1">
      <!-- Page title & actions -->
      <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
          <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Home</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
          <button type="button" class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-0">Share</button>
          <button type="button" class="order-0 inline-flex items-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:order-1 sm:ml-3">Create</button>
        </div>
      </div>
      <!-- Pinned projects -->

      <div class="mt-6 px-4 sm:px-6 lg:px-8 space-y-4">
        @if(Session::has('notification'))
        <x-alert.warning>
            {{ Session::get('notification') }}
        </x-alert.warning>
  
@endif
        <h2 class="text-sm font-medium text-gray-900">Pinned Projects</h2>
        <ul role="list" class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
          <li class="relative col-span-1 flex rounded-md shadow-sm">
            <div class="flex-shrink-0 flex items-center justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md">GA</div>
            <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
              <div class="flex-1 truncate px-4 py-2 text-sm">
                <a href="#" class="font-medium text-gray-900 hover:text-gray-600">GraphQL API</a>
                <p class="text-gray-500">12 Members</p>
              </div>
              <div class="flex-shrink-0 pr-2">
                <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2" id="pinned-project-options-menu-0-button" aria-expanded="false" aria-haspopup="true">
                  <span class="sr-only">Open options</span>
                  <!-- Heroicon name: mini/ellipsis-vertical -->
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                  </svg>
                </button>

                <!--
                  Dropdown menu, show/hide based on menu state.

                  Entering: "transition ease-out duration-100"
                    From: "transform opacity-0 scale-95"
                    To: "transform opacity-100 scale-100"
                  Leaving: "transition ease-in duration-75"
                    From: "transform opacity-100 scale-100"
                    To: "transform opacity-0 scale-95"
                -->
                <div class="absolute right-10 top-3 z-10 mx-3 mt-1 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="pinned-project-options-menu-0-button" tabindex="-1">
                  <div class="py-1" role="none">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="pinned-project-options-menu-0-item-0">View</a>
                  </div>
                  <div class="py-1" role="none">
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="pinned-project-options-menu-0-item-1">Removed from pinned</a>
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="pinned-project-options-menu-0-item-2">Share</a>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- More items... -->
        </ul>
      </div>

      <!-- Projects list (only on smallest breakpoint) -->
      <div class="mt-10 sm:hidden">
        <div class="px-4 sm:px-6">
          <h2 class="text-sm font-medium text-gray-900">Projects</h2>
        </div>
        <ul role="list" class="mt-3 divide-y divide-gray-100 border-t border-gray-200">
          <li>
            <a href="#" class="group flex items-center justify-between px-4 py-4 hover:bg-gray-50 sm:px-6">
              <span class="flex items-center space-x-3 truncate">
                <span class="w-2.5 h-2.5 flex-shrink-0 rounded-full bg-pink-600" aria-hidden="true"></span>
                <span class="truncate text-sm font-medium leading-6">
                  GraphQL API
                  <span class="truncate font-normal text-gray-500">in Engineering</span>
                </span>
              </span>
              <!-- Heroicon name: mini/chevron-right -->
              <svg class="ml-4 h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
              </svg>
            </a>
          </li>

          <!-- More projects... -->
        </ul>
      </div>

      <!-- Projects table (small breakpoint and up) -->
      <div class="mt-8 hidden sm:block">
        <div class="inline-block min-w-full border-b border-gray-200 align-middle">
          <table class="min-w-full">
            <thead>
              <tr class="border-t border-gray-200">
                <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900" scope="col">
                  <span class="lg:pl-2">Project</span>
                </th>
                <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900" scope="col">Members</th>
                <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell" scope="col">Last updated</th>
                <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900" scope="col"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
              <tr>
                <td class="w-full max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                  <div class="flex items-center space-x-3 lg:pl-2">
                    <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-pink-600" aria-hidden="true"></div>
                    <a href="#" class="truncate hover:text-gray-600">
                      <span>
                        GraphQL API
                        <span class="font-normal text-gray-500">in Engineering</span>
                      </span>
                    </a>
                  </div>
                </td>
                <td class="px-6 py-3 text-sm font-medium text-gray-500">
                  <div class="flex items-center space-x-2">
                    <div class="flex flex-shrink-0 -space-x-1">
                      <img class="h-6 w-6 max-w-none rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Dries Vincent">

                      <img class="h-6 w-6 max-w-none rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Lindsay Walton">

                      <img class="h-6 w-6 max-w-none rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Courtney Henry">

                      <img class="h-6 w-6 max-w-none rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Tom Cook">
                    </div>

                    <span class="flex-shrink-0 text-xs font-medium leading-5">+8</span>
                  </div>
                </td>
                <td class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">March 17, 2020</td>
                <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                </td>
              </tr>

              <!-- More projects... -->
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>