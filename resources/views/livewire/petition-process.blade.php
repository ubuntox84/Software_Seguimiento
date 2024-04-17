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
                <x-toogle-profile-mobile />

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
                            <x-button.link wire:click.prevent="toggleShowFilters">
                                @if ($showFilters)
                                    Ocultar
                                @endIf
                                Buscqueda avanzada...
                            </x-button.link>
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
                            {{-- <x-button.success class="w-full" wire:click="create">
                                <x-icon.plus /> Nuevo
                            </x-button.success> --}}
                        </div>
                        <div class="col-span-2  mt-1">
                            {{-- <x-dropdown label="Acciones ">
                                <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')"
                                    class="flex items-center space-x-2">
                                    <x-icon.trash class="text-gray-400" /> <span>Eliminar</span>
                                </x-dropdown.item>
                            </x-dropdown> --}}
                        </div>
                    </div>
                </div>
                <!--Top bar table Desktop-->
                <div class="hidden sm:block ">
                    <!--Top bar -->
                    <div class="flex justify-between  ">
                        <div class=" flex w-full lg:w-2/4 md:w-2/4 space-x-4">
                            <x-input.text wire:model.lazy="filters.search" placeholder="Buscar" type="search" />
                            <x-button.link class="text-blue-600 focus:text-blue-800"
                                wire:click.prevent="toggleShowFilters">
                                @if ($showFilters)
                                    Ocultar
                                @endIf
                                Búsqueda avanzada...
                            </x-button.link>

                        </div>

                        <div class="space-x-2 flex items-center">
                            <x-input.group borderless inline paddingless for="perPage" label="">
                                <x-input.select wire:model="perPage" id="perPage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </x-input.select>
                            </x-input.group>

                           
                        </div>
                    </div>

                </div>
                <!--busqueda avanzada-->
                <div class="mx-4 md:mx-0">
                    @if ($showFilters)
                        <div class="bg-gray-200 p-4 rounded mt-6 shadow-inner flex relative">
                            <div class="w-1/2 pr-2 space-y-4">
                                <x-input.group for="state" label="Estado">
                                    <x-input.select wire:model="filters.state" id="state">
                                        <option value="">seleccionar un estado</option>
                                        <option value="2">Pendiente</option>
                                        <option value="3">En Proceso</option>
                                        <option value="4">Aprobado</option>
                                        <option value="5">Rechazado</option>
                                        <option value="6">Completado</option>
                                        <option value="7">Cancelada</option>
                                    </x-input.select>
                                </x-input.group>

                                <x-input.group for="process" label="Proceso">
                                    <x-input.select wire:model="filters.process" id="process">
                                        <option value="">seleccionar un proceso</option>
                                        <option value="2">En Espera</option>
                                        <option value="3">En Proceso</option>
                                        <option value="4">Finalizado</option>
                                    </x-input.select>
                                </x-input.group>
                            </div>
                            <div class="w-1/2 pl-2 space-y-4">
                                <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">
                                    Reiniciar
                                    filtros</x-button.link>
                            </div>
                        </div>
                    @endif
                </div>
                <!--faculty Table-->
                <div class="-my-2 mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                        CÓDIGO</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        SOLICITANTE</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        ESTADO SOLICITUD</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        ESTADO PROGRESO</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                        <span class="sr-only">OPCIONES</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                @forelse ($petitionProcess as $petition)
                                                    <tr wire:key="petition-{{ $petition->id }}">
                                                        <td
                                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                            {{ mb_strtoupper($petition->code_petition) }} -
                                                            {{ mb_strtoupper($petition->petition->code) }}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ mb_strtoupper($petition->user_petition->name) }}
                                                            {{ mb_strtoupper($petition->user_petition->surname) }}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            <div>
                                                                @if ($petition->state_petition == 2)
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Pendiente</span>
                                                                @elseif ($petition->state_petition == 3)
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En
                                                                        Proceso</span>
                                                                @elseif ($petition->state_petition == 4)
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Aprobado</span>
                                                                @elseif ($petition->state_petition == 5)
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Rechazado</span>
                                                                @elseif ($petition->state_petition == 6)
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Completado</span>
                                                                @else
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">Cancelada</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            <div>
                                                                @if ($petition->processing_status == 2)
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">En
                                                                        Espera</span>
                                                                @elseif ($petition->processing_status == 3)
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En
                                                                        Proceso</span>
                                                                @elseif ($petition->processing_status == 4)
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Finalizado</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="space-x-2  flex justify-center items-center">
                                                                <div class=" text-center">
                                                                    
                                                                    @if ($petition->state_petition != 5 && $petition->state_petition != 7)
                                                                        <x-button.info-icon data-toggle="tooltip" wire:key="{{ uniqid() }}"
                                                                            title="Procesar"
                                                                            wire:click="processorPetition({{ $petition }})">
                                                                            <x-icon.square3>

                                                                            </x-icon.square3>
                                                                        </x-button.info-icon>
                                                                    @endif

                                                                    <x-button.gray-icon data-toggle="tooltip" wire:key="{{ uniqid() }}"
                                                                        title="Ver más"
                                                                        wire:click.prevent="show({{ $petition->id }})">
                                                                        <x-icon.eye>

                                                                        </x-icon.eye>
                                                                    </x-button.gray-icon>
                                                                    @if ($petition->state_petition != 5 && $petition->state_petition != 7 && $petition->state_petition == 2 || $petition->state_petition == 3 )
                                                                        <x-button.danger-icon data-toggle="tooltip" wire:key="{{ uniqid() }}"
                                                                            title="Cancelar"
                                                                            wire:click.prevent="showRejectModal({{ $petition->id }})">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="1.5"
                                                                                stroke="currentColor" class="w-5 h-5">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                            </svg>

                                                                        </x-button.danger-icon>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8">
                                                            <div class="flex justify-center items-center">
                                                                <x-icon.inbox
                                                                    class="h-8 w-8 text-neutral-400 space-x-2" />
                                                                <span
                                                                    class="font-medium py-8 text-neutral-500 text-xl">
                                                                    Aún no ha realizado solicitudes ...
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                </div>
                {{ $petitionProcess->links() }}
            </div>

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
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Pendiente</span>
                                                @elseif ($detailPetition->state_petition == 3)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En
                                                        Proceso</span>
                                                @elseif ($detailPetition->state_petition == 4)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Aprobado</span>
                                                @elseif ($detailPetition->state_petition == 5)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Rechazado</span>
                                                @elseif ($detailPetition->state_petition == 6)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Completado</span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">Cancelada</span>
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
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="w-6 h-6">
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
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="w-6 h-6">
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
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">En
                                                        Espera</span>
                                                @elseif ($detailPetition->processing_status == 3)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En
                                                        Proceso</span>
                                                @elseif ($detailPetition->processing_status == 4)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Finalizado</span>
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
                                                        <li
                                                            class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
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
                                                        <li
                                                            class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                            <div class="flex w-0 flex-1 items-center">
                                                                <!-- Heroicon name: mini/paper-clip -->


                                                                <span class="ml-2 w-0 flex-1 truncate">Ninguno</span>
                                                            </div>
                                                            <div class="ml-4 flex-shrink-0">

                                                            </div>
                                                        </li>
                                                    @endforelse
                                                @else
                                                    <li
                                                        class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
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
                <!--modal alert!-->
                <div>
                    <div x-cloak x-data="{ open: @entangle('modalCancelRequest') }" @keydown.window.escape="open = false" class="relative z-10"
                        x-show="open" aria-labelledby="modal-title" role="dialog" aria-modal="true">

                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                        <div x-show="open" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 overflow-y-auto">
                            <div
                                class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                                <div
                                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                    <div class="sm:flex sm:items-start">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                            <h3 class="text-base font-semibold leading-6 text-gray-900"
                                                id="modal-title">
                                                Cacelar
                                                Solicitud</h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">¿Estás seguro de que deseas Cancelar
                                                    la
                                                    solicitud?
                                                    Esta acción no se puede deshacer.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                        <button type="button"
                                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                            wire:click.prevent="rejectCancel()">Si, aceptar</button>
                                        <button type="button"
                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                            @click="open = false">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--modal alert fin!-->
            </form>
    </main>

</div>
