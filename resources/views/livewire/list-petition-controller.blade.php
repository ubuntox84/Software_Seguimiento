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
                showFormEditAlp:false
	
	    }">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Mis Solicitudes</h1>
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
                            <x-button.link wire:click.prevent="toggleShowFilters">@if($showFilters) Ocultar @endIf
                                Buscqueda avanzada...</x-button.link>
                        </div>
                        <div>
                            {{-- <x-input.group borderless paddingless for="perPage" label="">
                                <x-input.select wire:model="perPage" id="perPage">
                                    <option value="1">1</option>
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
                            <x-input.text wire:model.lazy="filters.search" placeholder="Buscar Código" type="search" />
                            {{-- <x-button.link class="text-blue-600 focus:text-blue-800"
                                wire:click.prevent="toggleShowFilters">
                                @if($showFilters) Ocultar @endIf
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
                                <x-table.heading class="whitespace-nowrap" scope="col"> Nombre
                                </x-table.heading>
                                <x-table.heading class="whitespace-nowrap " scope="col">Código</x-table.heading>
                               
                                <x-table.heading class="whitespace-nowrap " scope="col">Estado Solicitud
                                </x-table.heading>
                                <x-table.heading class="whitespace-nowrap" scope="col">Estado Progreso</x-table.heading>
                                <x-table.heading> Opciones</x-table.heading>
                            </x-slot>
                            <x-slot name="body">
                                @if ($selectPage)
                                <x-table.row wire:key="row-message">
                                    <x-table.cell class="bg-gray-200" colspan="9">
                                        @unless ($selectAll)
                                        <div>
                                            <span> Selecccionaste <strong> {{ $userPetitions->count() }} </strong>
                                                Solicitudes, ¿ desea selecionar todas las <strong>{{
                                                    $userPetitions->total()
                                                    }}</strong>? </span>
                                            <x-button.link wire:click.prevent="selectAll" class="ml-2 text-blue-600">
                                                Seleccionar todo</x-button.link>
                                        </div>
                                        @else
                                        <span> Actuallmente selecccionaste todas las <strong>{{ $userPetitions->total()
                                                }}</strong> Solicitudes.</span>
                                        @endif
                                    </x-table.cell>
                                </x-table.row>
                                @endif
                                @forelse ($userPetitions as $petition)
                                <x-table.row wire:loading.class.delay="opacity-50"
                                    wire:key="petition-{{ $petition->id }}">
                                    <x-table.cell class="" col-span="1">
                                        <x-input.checkbox wire:model="selected" value="{{$petition->id}}" />
                                    </x-table.cell>
                                    <x-table.cell class="whitespace-nowrap ">
                                       {{mb_strtoupper($petition->petition->name) }}
                                    </x-table.cell>

                                    <x-table.cell class="whitespace-nowrap ">{{
                                        mb_strtoupper($petition->code_petition ?? '') }}
                                    </x-table.cell>

                                   
                                    <x-table.cell class="whitespace-nowrap">

                                        @if ($petition->state_petition == 2)
                                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Pendiente</span>
                                            @elseif ($petition->state_petition == 3)
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En Proceso</span>
                                            @elseif ($petition->state_petition == 4)
                                                <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Aprobado</span>
                                            @elseif ($petition->state_petition == 5)
                                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Rechazado</span>
                                            @elseif ($petition->state_petition == 6)
                                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Completado</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">Cancelada</span>
                                            @endif 
                                    </x-table.cell>
                                    <x-table.cell class="whitespace-nowrap">

                                       @if ($petition->processing_status == 2)
                                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">En Espera</span>
                                            @elseif ($petition->processing_status == 3)
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En Proceso</span>
                                            @elseif ($petition->processing_status == 4)
                                                <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Finalizado</span>
                                            @endif
                                    </x-table.cell>
                                    <x-table.cell class="">
                                        <div class="space-x-2  flex justify-center items-center">
                                            <div class=" text-center">
                                                <x-button.warning-icon wire:click.defer="edit({{ $petition->id}})">
                                                    <x-icon.edit>

                                                    </x-icon.edit>
                                                </x-button.warning-icon>
                                                 <x-button.gray-icon data-toggle="tooltip" title="Ver más"
                                                        wire:click.defer="show({{ $petition->id }})">
                                                        <x-icon.eye>

                                                        </x-icon.eye>
                                                    </x-button.gray-icon>
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
                                                Aún no ha realizado solicitudes ...
                                            </span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table>
                    </div>
                </div>
                {{ $userPetitions->links() }}
            </div>

            <!--Edit And Create solicitud Modal-->
            <form>
                <x-modal.dialog wire:model="showEditModal">

                    <x-slot name="title">Editar Solicitud </x-slot>

                    <x-slot name="content">
                        <div class="grid grid-cols-6 gap-6">
                            <x-input.group label="Código" for="code_petition" clases="col-span-6 sm:col-span-6"
                                :error="$errors->first('editing.code_petition')">
                                <x-input.text wire:model.lazy="editing.code_petition" id="code_petition" type="text" />
                            </x-input.group>


                            <x-input.group label="Asunto" for="subject" clases="col-span-6 sm:col-span-6"
                                :error="$errors->first('editing.subject')">
                                <x-input.text-area clases="col-span-6 sm:col-span-6" wire:model.lazy="editing.subject"
                                    id="subject" />
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
       <form>
        <x-modal.dialog maxWidth="4xl" wire:model="showPetition">

            <x-slot name="title">

            </x-slot>


            <x-slot name="content">
                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Detalle de la Solicitud</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Datos personales y solicitud.</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)
                                        {{ $detailPetition->user_petition->name }}
                                        {{ $detailPetition->user_petition->surname }}
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Correo </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)
                                        {{ $detailPetition->user_petition->email }}
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Solicitud de</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailPetition)
                                        {{ strtoupper($detailPetition->petition->name) }}
                                    @endif

                                </dd>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Asunto</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)
                                        {{ $detailPetition->subject }}
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Codigo de Solicitud</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailPetition)
                                        {{ $detailPetition->code_petition }}
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Fecha de Solicitud</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)
                                        {{ $detailPetition->created_at }}
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Estado de solicitud</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)
                                        @if ($detailPetition->state_petition == 2)
                                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Pendiente</span>
                                        @elseif ($detailPetition->state_petition == 3)
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En Proceso</span>
                                        @elseif ($detailPetition->state_petition == 4)
                                            <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Aprobado</span>
                                        @elseif ($detailPetition->state_petition == 5)
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Rechazado</span>
                                        @elseif ($detailPetition->state_petition == 6)
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Completado</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">Cancelada</span>
                                        @endif
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Archivos adjuntos</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <ul role="list"
                                        class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex w-0 flex-1 items-center">
                                                <!-- Heroicon name: mini/paper-clip -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>

                                                <span class="ml-2 w-0 flex-1 truncate">imagen solicitud</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                @if ($detailPetition)
                                                    <a href="#"
                                                        wire:click="downloadImagePetition({{ $detailPetition }})"
                                                        class="font-medium text-indigo-600 hover:text-indigo-500">Descargar</a>
                                                @endif
                                            </div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex w-0 flex-1 items-center">
                                                <!-- Heroicon name: mini/paper-clip -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>

                                                <span class="ml-2 w-0 flex-1 truncate">imagen Voucher</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                @if ($detailPetition)

                                                    @if ($detailPetition)
                                                        <a href="#"
                                                            wire:click="downloadImageVoucher({{ $detailPetition }})"
                                                            class="font-medium text-indigo-600 hover:text-indigo-500">Descargar</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </dd>
                            </div>


                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Observaciones</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)

                                        @if ($detailPetition->observations)
                                            {{ $detailPetition->observations }}
                                        @else
                                            Ninguna
                                        @endif
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Estado de Proceso</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)
                                         @if ($detailPetition->processing_status == 2)
                                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">En Espera</span>
                                            @elseif ($detailPetition->processing_status == 3)
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En Proceso</span>
                                            @elseif ($detailPetition->processing_status == 4)
                                                <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Finalizado</span>
                                            @endif
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Fecha de Procesamiento</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)

                                        @if ($detailPetition->processing_date)
                                            {{ $detailPetition->processing_date }}
                                        @else
                                            En espera...
                                        @endif
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Procesado Por</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailPetition)

                                        @if ($detailPetition->user_processor)
                                            {{ $detailPetition->user_processor->name }}
                                            {{ $detailPetition->user_processor->surname }}
                                        @else
                                            No Asginado..
                                        @endif

                                    @endif

                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Cursos Solicitados</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    <ul role="list"
                                        class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                        @if (isset($detailPetition->courses) && is_array($detailPetition->courses) && !empty($detailPetition->courses))
                                            @forelse ($detailPetition->courses as $item)
                                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                    <div class="flex w-0 flex-1 items-center">
                                                        <!-- Heroicon name: mini/paper-clip -->


                                                        <span
                                                            class="ml-2 w-0 flex-1 truncate">{{ $item['name'] }}</span>
                                                    </div>
                                                    <div class="ml-4 flex-shrink-0">
                                                        @if ($detailPetition)
                                                            <span
                                                                class="font-medium text-green-600 hover:text-green-500">{{ $item['course']['name'] }}</span>
                                                        @endif
                                                    </div>
                                                </li>

                                            @empty
                                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                    <div class="flex w-0 flex-1 items-center">
                                                        <!-- Heroicon name: mini/paper-clip -->


                                                        <span class="ml-2 w-0 flex-1 truncate">Ninguno</span>
                                                    </div>
                                                    <div class="ml-4 flex-shrink-0">

                                                    </div>
                                                </li>
                                            @endforelse
                                        @else
                                            <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                <div class="flex w-0 flex-1 items-center">
                                                    <!-- Heroicon name: mini/paper-clip -->


                                                    <span class="ml-2 w-0 flex-1 truncate">Ninguno</span>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">

                                                </div>
                                            </li>
                                        @endif

                                    </ul>

                                </dd>
                            </div>

                        </dl>
                    </div>
                </div>




            </x-slot>

            <x-slot name="footer">

                <x-button.danger wire:click="$set('showPetition', false)">Cerrar</x-button.danger>
                {{-- <x-button.success wire:click.prevent="save">Guardar</x-button.success> --}}



            </x-slot>

        </x-modal.dialog>
    </form>

</div>