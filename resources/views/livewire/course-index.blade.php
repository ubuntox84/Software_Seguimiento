<div class="flex flex-col lg:pl-64">
  <!-- Search header -->
  <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white lg:hidden">
    <!-- Sidebar toggle, controls the 'sidebarOpen' sidebar state. -->
    <button x-data @click="mobileShowHidden=true" type="button"
    class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden">
    <span class="sr-only">Open sidebar</span>
    <!-- Heroicon name: outline/bars-3-center-left -->
    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
      stroke="currentColor" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
    </svg>

  </button>
    <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
      <div class="flex flex-1">
        {{-- <form class="flex w-full md:ml-0" action="#" method="GET">
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
        </form> --}}
      </div>
      <div class="flex items-center">
        <!-- Profile dropdown -->
        <div class="relative ml-3">
          <div>
            <button @click="profileMobileShowHidden=!profileMobileShowHidden" type="button"
              class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
              id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="sr-only">Open user menu</span>
              <img class="h-8 w-8 rounded-full"
                src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt="">
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
          <div x-cloak x-show="profileMobileShowHidden"
            class="absolute right-0 z-10 mt-2 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            <div class="py-1" role="none">
              <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                id="user-menu-item-0">View profile</a>
              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                id="user-menu-item-1">Settings</a>
              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                id="user-menu-item-2">Notifications</a>
            </div>
            <div class="py-1" role="none">
              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                id="user-menu-item-3">Get desktop app</a>
              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                id="user-menu-item-4">Support</a>
            </div>
            <div class="py-1" role="none">
              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                id="user-menu-item-5">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <main 
  x-data="{
    OpenFormCreateCourse:false,
    OpenFormCreateArea:false,
    OpenFormEditCourse:false,
    modalDelete:false,
    OpenFormEditArea:false
  }"
  class="flex-1">
    <!-- Page title & actions -->
    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
      <div class="min-w-0 flex-1">
        <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Cursos</h1>
      </div>
      <div class="mt-4 flex flex-wrap  sm:mt-0 sm:ml-4">
        
        {{-- <button type="button" class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-0">Share</button>
        <button type="button" class="order-0 inline-flex items-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:order-1 sm:ml-3">Create</button> --}}
        
      <button @click.prenvent="$wire.emit('loadAreaKnowlead');OpenFormCreateCourse=true" type="button"
        class="order-0 inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:order-1 sm:ml-3">Crear
        Curso</button>
      <button @click.prevent="OpenFormCreateArea=true" type="button"
        class="order-0 inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:order-1 sm:ml-3">Crear
        Área de Conocimiento</button>
      </div>
    </div>
    <!-- Pinned projects -->
    {{-- <div class="mt-6 px-4 sm:px-6 lg:px-8">
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
    </div> --}}

    <!-- Projects list (only on smallest breakpoint) -->
    {{-- <div class="mt-10 sm:hidden">
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
    </div> --}}

    <!-- Projects table (small breakpoint and up) -->
    <div class="px-4 sm:px-6 lg:px-8 mt-4">
      <div class="sm:flex sm:items-center">
        <div class="flex flex-col md:flex-row md:items-center">
          <div class="md:mr-4">
            <div class="pointer-events-none absolute mt-2 flex items-center pl-1">
              <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"></path>
              </svg>
            </div>
            <input wire:model="search" id="search"
              class="focus:shadow-outline-blue block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 leading-5 placeholder-gray-500 transition duration-150 ease-in-out focus:border-blue-300 focus:placeholder-gray-400 focus:outline-none sm:text-sm"
              placeholder="Buscar" type="search">
          </div>
          <div >
            <select wire:model="sizePage" id="location" name="location"
              class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
              <option selected value="10">10</option>
              <option value="20">20</option>
              <option value="50">50</option>
              <option value="100">100</option>
              <option value="500">500</option>
            </select>
          </div>
        </div>
      
      </div>
      <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle  ">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
              @if (!$areaKnowledgesList->isEmpty())
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                  <tr>
                    <th class=" text-left pl-6 text-sm font-semibold text-gray-900">
                      Código</th>
                    <th class="text-left text-sm font-semibold text-gray-900">
                      Nombre</th>
                    <th class="text-left text-sm font-semibold text-gray-900">
                      Horas Teóricas</th>
                    <th class="text-left text-sm font-semibold text-gray-900">
                      Horas Prácticas </th>
                    <th class="text-left text-sm font-semibold text-gray-900">
                      Tipo de Curso </th>
                    <th class="text-left text-sm font-semibold text-gray-900">
                      Creditos </th>
                    <th class="text-left text-sm font-semibold text-gray-900">
                      Ciclo </th>
      
                    <th class=" pl-3 pr-4 sm:pr-6">
                      Opciones
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200  bg-white">
                  @foreach ($areaKnowledgesList as $AreaKnowledge=>$areas)
                  <tr class="border-t border-gray-200 bg-gray-100  ">
                    <td colspan="7" scope="colgroup" class="px-4 py-1 text-left text-sm font-semibold text-gray-900 sm:px-6">
                      {{ $areas->name }}
                
                    </td>
                    <td class="text-center">
                      <div class=" lg:pl-3  flex-1 items-center ">
                        <button @click.prevent="$wire.emit('loadEditFormAreaKnowledge',{{ $areas->id }});OpenFormEditArea=true"
                          type="button"
                          class="flex-1 h-5 w-5 items-center justify-center rounded-full  text-green-400 hover:bg-green-200 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                          <svg class=" h-5 w-5 text-green-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path
                            d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                          <path
                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                          </button>
                        <button @click.prenvent="$wire.deleteId({{ $areas->id }},'area');modalDelete=true" type="button"
                          class="flex-1 h-5 w-5 items-center justify-center rounded-full  text-red-800 hover:bg-red-200 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                          <svg class=" h-5 w-5 text-red-700 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                              d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                              clip-rule="evenodd" />
                          </svg>
                        </button>
                      </div>
                    </td>
                 
                  </tr>
                    @foreach ($areas->courses as $course)
                    <tr class="border-t border-gray-300">
                      <td class="whitespace-nowrap  pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                        {{ $course->code }}</td>
                      <td class="whitespace-nowrap px-3  text-sm text-gray-500">
                        {{ $course->name }}</td>
                      <td class="whitespace-nowrap px-3  text-sm text-gray-500">
                        {{ $course->theoretic_hour }}</td>
                      <td class="whitespace-nowrap px-3  text-sm text-gray-500">
                        {{ $course->practical_hour }}</td>
                      <td class="whitespace-nowrap px-3  text-sm text-gray-500">
                        {{ $course->type_course }}</td>
                      <td class="whitespace-nowrap px-3  text-sm text-gray-500">
                        {{ $course->credits }}</td>
                      <td class="whitespace-nowrap px-3  text-sm text-gray-500">
                        {{ $course->cycle }}</td>
        
        
                      <td class="relative whitespace-nowrap   pr-4 text-right text-sm font-medium sm:pr-6">
                        <div class="  text-center ">
        
                          <button @click.prevent="$wire.emit('loadFormEditCourse',{{ $course->id }});OpenFormEditCourse=true"
                            type="button"
                            class=" h-5 w-5 items-center justify-center rounded-full  text-green-400 hover:bg-green-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class=" h-5 w-5 text-green-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path
                                d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                              <path
                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                            </svg>
                            <span class="sr-only">Add description</span>
                          </button>
        
                          <button @click.prenvent="$wire.deleteId({{ $course->id }},'curso');modalDelete=true" type="button"
                            class=" h-5 w-5 items-center justify-center rounded-full  text-red-800 hover:bg-red-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class=" h-5 w-5 text-red-700 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd"
                                d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                clip-rule="evenodd" />
                            </svg>
        
                            <span class="sr-only">Add description</span>
                          </button>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  @endforeach
                </tbody>
              </table>
              <div class="mt-2">
                {{ $areaKnowledgesList->links() }}
              </div>
            
            @else
            <div class="text-center">
              <p class="inline-flex items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800">
                No hay registros</p>
            </div>
            @endif
            
                        <livewire:create-curso>
                        <livewire:create-area-knowledge>
                        <livewire:edit-area-knowledge>
                        <livewire:edit-course>      
            </div>
          </div>
          <x-notification-success />
          @if ($showModal==='area')
          <x-modal-confirm>
            <x-slot name="title">
              Eliminar área de conocimiento:
            </x-slot>
            <x-slot name="description">
              ¿Estas seguro de eliminar
              este registro? Estos registros serán eliminados
              permanentemente. Esta acción no se puede deshacer..
            </x-slot>
            <x-slot name="button">
              <button @click.prevent="$wire.deleteAreaKnowledge();modalDelete=false" type="button"
                class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                Si, Eliminar
              </button>
              <button @click.prevent="modalDelete=false" type="button"
                class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancelar
              </button>
            </x-slot>
          </x-modal-confirm>
          @elseif($showModal==='curso')
          <x-modal-confirm>
            <x-slot name="title">
              Eliminar Curso:
            </x-slot>
            <x-slot name="description">
              ¿Estas seguro de eliminar
              este registro? Estos registros serán eliminados
              permanentemente. Esta acción no se puede deshacer..
            </x-slot>
            <x-slot name="button">
              <button @click.prevent="$wire.deleteCourse;modalDelete=false" type="button"
                class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                Si, Eliminar
              </button>
              <button @click.prevent="modalDelete=false" type="button"
                class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancelar
              </button>
            </x-slot>
          </x-modal-confirm>
          @else
          @endif
        </div>
      </div>
    </div>
    
  </main>
</div>