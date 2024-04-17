<div class="flex flex-col lg:pl-64">
    <!-- Search header -->
    <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white lg:hidden">
        <!-- Sidebar toggle, controls the 'sidebarOpen' sidebar state. -->
        <button @click="mobileShowHidden = true" type="button"
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
                <form class="flex w-full md:ml-0" action="#" method="GET">
                    <div class="relative w-full mt-2 text-gray-400 focus-within:text-gray-600">
                        <div class="pointer-events-none absolute pb-3 inset-y-0 left-0 flex items-center">
                            <!-- Heroicon name: mini/magnifying-glass -->
                            <x-icon.search />
                        </div>
                        <x-input.text wire:model="filters.search"
                            class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
                            placeholder="buscar" type="search" />
                    </div>


                </form>
            </div>
             <div class="flex items-center">
                <x-toogle-profile-mobile/>

            </div>
        </div>
    </div>
    <main class="flex-1" x-data="{
        showFormCreate: false,
        modalDelete: false,
        showFormEditAlp: false
    
    }">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Socitudes</h1>
            </div>
            {{-- <div class="mt-4 flex sm:mt-0 sm:ml-4">
        <button type="button" @click="showFormCreate=true"
          class="order-0 inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:order-1 sm:ml-3">
          Agregarfaculty
        </button>

      </div> --}}
        </div>

        <!-- list-->
        <div class="sm:px-6 lg:px-8 flex flex-col">

            <div class="mt-4 flex flex-col space-y-4 ">
                <!--Top bar table mobile-->
                <div class=" mx-4 mt-10 sm:hidden">
                    <div class="grid grid-cols-5 gap-2">
                        <div class="col-span-5 mt-4">
                            <x-button.link wire:click.prevent="toggleShowFilters">
                                @if ($showFilters) Ocultar @endIf
                                Buscqueda avanzada...
                            </x-button.link>
                        </div>
                        <div>
                            {{-- <x-input.group borderless paddingless for="perPage" label="">
                                <x-input.select wire:model="perPage" id="perPage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </x-input.select>
                            </x-input.group> --}}
                        </div>

                        <div class="col-span-2 mt-2 w-full">
                            <x-button.success class="w-full" wire:click="create">
                                <x-icon.plus /> Nuevo
                            </x-button.success>
                        </div>
                        <div class="col-span-2  mt-1">
                            <x-dropdown label="Acciones ">
                                <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')"
                                    class="flex items-center space-x-2">
                                    <x-icon.trash class="text-gray-400" /> <span>Eliminar</span>
                                </x-dropdown.item>
                            </x-dropdown>
                        </div>
                    </div>
                </div>
                <!--Top bar table Desktop-->
                <div class="hidden sm:block ">
                    <!--Top bar -->
                    <div class="flex justify-between  ">
                        <div class=" flex w-full lg:w-2/4 md:w-2/4 space-x-4">
                            <x-input.text wire:model.lazy="filters.search" placeholder="Buscar" type="search" />
                            {{-- <x-button.link class="text-blue-600 focus:text-blue-800" wire:click.prevent="toggleShowFilters">
                @if ($showFilters) Ocultar @endIf
                Búsqueda avanzada...</x-button.link> --}}
                        </div>

                        <div class="space-x-2 flex items-center">
                            <x-input.group borderless inline paddingless for="perPage" label="">
                                <x-input.select wire:model="perPage" id="perPage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </x-input.select>
                            </x-input.group>

                            <x-dropdown label="Acciones ">

                                <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')"
                                    class="flex items-center space-x-2">
                                    <x-icon.trash class="text-red-500" /> <span>Eliminar</span>
                                </x-dropdown.item>
                            </x-dropdown>
                            <x-button.success wire:click="create">
                                <x-icon.plus /> Nuevo
                            </x-button.success>
                        </div>
                    </div>

                </div>
                <!--busqueda avanzada-->
                {{-- <div class="mx-4 md:mx-0">
          @if ($showFilters)
          <div class="bg-gray-200 p-4 rounded mt-6 shadow-inner flex relative">
            <div class="w-1/2 pr-2 space-y-4">
              <x-input.group for="filter-date-min" label="Fecha mínima">
                <x-input.text wire:model.lazy="filters.date-min" type="date" />
              </x-input.group>

              <x-input.group for="filter-date-max" label="Fecha máxima">
                <x-input.text wire:model.lazy="filters.date-max" id="filter-date-max" type="date" />
              </x-input.group>
            </div>
            <div class="w-1/2 pl-2 space-y-4">
              <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reiniciar
                filtros</x-button.link>
            </div>
          </div>
          @endif
        </div> --}}
                <!--faculty Table-->
                <div class="-my-2 mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    {{-- @json($filters) --}}
                    <div class="space-y-4 inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <x-table>
                            <x-slot name="head">
                                <x-table.heading scope="col">
                                    <x-input.checkbox wire:model="selectPage">
                                    </x-input.checkbox>
                                </x-table.heading>
                                <x-table.heading class="whitespace-nowrap" scope="col" sortable multi-column
                                    wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">Nombre
                                </x-table.heading>
                                <x-table.heading scope="col" sortable multi-column wire:click="sortBy('code')"
                                    :direction="$sorts['code'] ?? null">Código
                                </x-table.heading>
                                <x-table.heading scope="col" sortable multi-column
                                    wire:click="sortBy('description')" :direction="$sorts['description'] ?? null">Descripción
                                </x-table.heading>
                                <x-table.heading scope="col" sortable multi-column wire:click="sortBy('state')"
                                    :direction="$sorts['state'] ?? null">Estado
                                </x-table.heading>
                                <x-table.heading> Opciones</x-table.heading>
                            </x-slot>
                            <x-slot name="body">
                                @if ($selectPage)
                                    <x-table.row wire:key="row-message">
                                        <x-table.cell class="bg-gray-200" colspan="8">
                                            @unless ($selectAll)
                                                <div>
                                                    <span> Selecccionaste <strong> {{ $petitions->count() }} </strong>
                                                        Solicitudes, ¿ desea selecionar todas las
                                                        <strong>{{ $petitions->total() }}</strong>? </span>
                                                    <x-button.link wire:click.prevent="selectAll"
                                                        class="ml-2 text-blue-600">
                                                        Seleccionar todo</x-button.link>
                                                </div>
                                            @else
                                                <span> Actuallmente selecccionaste todas las
                                                    <strong>{{ $petitions->total() }}</strong> Solicitudes.</span>
                                    @endif
                                    </x-table.cell>
                                    </x-table.row>
                                    @endif
                                    @forelse ($petitions as $petition)
                                        <x-table.row wire:loading.class.delay="opacity-50"
                                            wire:key="petition-{{ $petition->id }}">
                                            <x-table.cell class="" col-span="1">
                                                <x-input.checkbox wire:model="selected" value="{{ $petition->id }}" />
                                            </x-table.cell>
                                            <x-table.cell class="whitespace-nowrap ">
                                                {{ mb_strtoupper($petition->name) }}</x-table.cell>
                                            <x-table.cell class="whitespace-nowrap ">
                                                {{ mb_strtoupper($petition->code ?? '') }}
                                            </x-table.cell>
                                            <x-table.cell class="">{{ mb_strtoupper($petition->description ?? '') }}
                                            </x-table.cell>
                                            <x-table.cell class="whitespace-nowrap">
                                                @if ($petition->state == 1)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Disponible</span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">No
                                                        Disponible</span>
                                                @endif
                                            </x-table.cell>
                                            <x-table.cell class="">
                                                <div class="space-x-2  flex justify-center items-center">
                                                    <div class=" text-center">
                                                        <x-button.warning-icon
                                                            wire:click.defer="edit({{ $petition->id }})">
                                                            <x-icon.edit>

                                                            </x-icon.edit>
                                                        </x-button.warning-icon>
                                                    </div>

                                                </div>
                                            </x-table.cell>
                                        </x-table.row>
                                    @empty
                                        <x-table.row>
                                            <x-table.cell colspan="8">
                                                <div class="flex justify-center items-center">
                                                    <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                                    <span class="font-medium py-8 text-neutral-500 text-xl">
                                                        Solicitudes no encontradas...
                                                    </span>
                                                </div>
                                            </x-table.cell>
                                        </x-table.row>
                                    @endforelse
                                </x-slot>
                            </x-table>
                            {{ $petitions->links() }}
                        </div>
                    </div>
                </div>

                <!--Edit And Create solicitud Modal-->
                <form>
                    <x-modal.dialog wire:model="showEditModal">

                        <x-slot name="title">Solicitud </x-slot>

                        <x-slot name="content">
                            <div class="grid grid-cols-6 gap-6">
                                <x-input.group label="Nombre" for="name" clases="col-span-6 sm:col-span-4"
                                    :error="$errors->first('editing.name')">
                                    <x-input.text wire:model.lazy="editing.name" id="name" type="text" />
                                </x-input.group>
                                <x-input.group label="Código" for="code" clases="col-span-6 sm:col-span-2"
                                    :error="$errors->first('editing.code')">
                                    <x-input.text wire:model.lazy="editing.code" id="code" type="text" />
                                </x-input.group>
                                @if (isset($editing->id))
                                    <x-input.group label="Estado" for="state" clases="col-span-6 sm:col-span-6"
                                        :error="$errors->first('editing.state')">
                                        <x-input.select wire:model="editing.state">
                                            <option value="" selected>selecione Estado</option>

                                            <option value="0">No Disponilbe</option>
                                            <option value="1">Disponible</option>

                                        </x-input.select>
                                    </x-input.group>
                                @endif
                                <x-input.group label="Descripcion" for="description" clases="col-span-6 sm:col-span-6"
                                    :error="$errors->first('editing.description')">
                                    <x-input.text-area clases="col-span-6 sm:col-span-6"
                                        wire:model.lazy="editing.description" id="description" />
                                </x-input.group>

                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <x-button.danger wire:click="$set('showEditModal', false)">Cancelar</x-button.danger>
                            <x-button.success wire:click.prevent="save">Guardar</x-button.success>
                        </x-slot>
                    </x-modal.dialog>
                </form>

                <!--Confirm Delete solicitud Modal-->
                <form>
                    <x-modal.confirmation wire:model.defer="showDeleteModal">
                        <div class="grid grid-cols-6 gap-6">
                            <x-slot name="title">Eliminar Solicitud </x-slot>
                            <x-slot name="content">
                                ¿Estas seguro de eliminar esta solicitud? Esta acción es irreversible.
                            </x-slot>
                            <x-slot name="footer">
                                <x-button.secondary wire:click.prevent="$set('showDeleteModal', false)">Cancelar
                                </x-button.secondary>
                                <x-button.danger wire:click.prevent="deleteSelected">Eliminar</x-button.danger>
                            </x-slot>
                        </div>
                    </x-modal.confirmation>
                </form>

                <!--Confirm Delete Department  Modal-->


            </div>
            {{--
    <x-notification-success /> --}}
        </main>

    </div>
