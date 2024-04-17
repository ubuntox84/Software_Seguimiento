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
        showFormEditAlp: false,
        showSolicitud: true,
        showForm: true,
        isUploading: false,
        progress: 0,
        showRecord: true,
        openModalConfirm:false
    }">
        <!-- Page title & actions -->
        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Tramitando Solicitud</h1>
            </div>
            {{-- <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <button type="button" @click="showFormCreate=true"
                    class="order-0 inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:order-1 sm:ml-3">
                    Agregarfaculty
                </button>

            </div> --}}


        </div>
        <div x-data="select({
            data: {{ json_encode($curriculaPetitions) }},
            option: {{ json_encode($option) }}, // Enlaza la variable de Livewire curriculas
            modelName: 'selected',
            showCurriculas: false,
            selectedIndex: 0,
            activeIndex: 0,

        
        
        })" x-init="init()" class="sm:px-6 lg:px-8 flex flex-col space-y-4"
            x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">

            <div class="mt-4 flex flex-col space-y-4 ">
                <div>
                    <div class="flex justify-between cursor-pointer hover:bg-gray-100  p-2 rounded-md"
                        :class="showSolicitud ? '' : 'bg-gray-50 border-b border-gray-300 shadow-md'"
                        @click="showSolicitud=!showSolicitud">
                        <div class="text-left">
                            <h3 x-cloak x-show="!showSolicitud" class="text-lg font-medium leading-6 text-gray-900">
                                Informacion de la Socilicitud
                            </h3>
                        </div>
                        <div class="text-right">
                            <button x-cloak x-show="showSolicitud" type="button"
                                class="inline-flex items-center rounded-full border border-transparent  text-red-500 shadow-sm hover:text-red-700"
                                title="Ocultar">
                                <!-- Heroicon name: mini/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                                <button x-cloak x-show="!showSolicitud" type="button"
                                    class="inline-flex items-center rounded-full border border-transparent  text-green-500 shadow-sm hover:text-green-700 "
                                    title="Mostrar">
                                    <!-- Heroicon name: mini/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>


                                </button>
                        </div>
                    </div>
                </div>
                <div x-show="showSolicitud" x-collapse>
                    <div>
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Solicitante</h3>
                                    <p class="mt-1 text-sm text-gray-600">Aquí se mostrara los datos completos del
                                        solicitante </p>
                                </div>

                            </div>
                            <div class="mt-5 md:col-span-2 md:mt-0">
                                <form action="#" method="POST">
                                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">

                                            <div class="grid grid-cols-4 gap-6">
                                                <div class="col-span-6 sm:col-span-4">
                                                    <label class="block text-sm font-medium text-gray-700">Foto</label>
                                                    <div class="mt-1 flex items-center">
                                                        <img class="inline-block h-14 w-14 rounded-full"
                                                            src="{{ $userPetition->user_petition->profile_photo_url }}"
                                                            alt="">

                                                    </div>
                                                </div>
                                                <div class="col-span-2 sm:col-span-2">
                                                    {{-- <label for="company-website"
                                                        class="block text-sm font-medium text-gray-700">Website</label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <span
                                                            class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">http://</span>
                                                        <input type="text" name="company-website" id="company-website"
                                                            class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                            placeholder="www.example.com">
                                                    </div> --}}

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Nombres
                                                            y
                                                            Apellidos</label>

                                                        <p class="mt-1 text-sm text-gray-500">
                                                            {{ $userPetition->user_petition->name }}
                                                            {{ $userPetition->user_petition->surname }}</p>
                                                    </div>

                                                </div>
                                                <div class="col-span-6 sm:col-span-2">


                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700">Código</label>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            {{ $userPetition->user_petition->code }}</p>
                                                    </div>

                                                </div>
                                                <div class="col-span-6 sm:col-span-2">


                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700">Correo</label>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            {{ $userPetition->user_petition->email }}</p>
                                                    </div>

                                                </div>
                                                <div class="col-span-6 sm:col-span-4">


                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700">Facultad</label>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            {{ $userPetition->user_petition->faculties->name }}</p>
                                                    </div>

                                                </div>
                                                @if ($userPetition->user_petition->departments)
                                                <div class="col-span-6 sm:col-span-4">

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700">Departamento</label>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            {{ $userPetition->user_petition->departments->name }}
                                                        </p>
                                                    </div>

                                                </div>
                                                @endif
                                            </div>






                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="hidden sm:block" aria-hidden="true">
                        <div class="py-5">
                            <div class="border-t border-gray-200"></div>
                        </div>
                    </div>

                    <div>
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Solicitud</h3>
                                    <p class="mt-1 text-sm text-gray-600">Aquí se mostrara los datos completos de la
                                        solicitud
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:col-span-2 md:mt-0">
                                <form action="#" method="POST">
                                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">

                                            <div class="grid grid-cols-4 gap-6">

                                                <div class="col-span-6 sm:col-span-6 space-y-4">


                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700">Nombre</label>

                                                        <p class="mt-1 text-sm text-gray-500">
                                                            {{ mb_strtoupper($userPetition->petition->name) }}</p>
                                                    </div </div>
                                                    <div class="col-span-6 sm:col-span-6">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700">Código</label>
                                                        <x-input.group label="" for="code-petition"
                                                            clases="col-span-6 sm:col-span-2"
                                                            :error="$errors->first('userPetition.code_petition')">
                                                            <x-input.text wire:model.lazy="userPetition.code_petition"
                                                                id="code-petition" type="text" />
                                                        </x-input.group>

                                                    </div>
                                                    <div class="col-span-6 sm:col-span-6">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700">Asunto</label>
                                                        <x-input.group label="" for="subject"
                                                            clases="col-span-6 sm:col-span-2"
                                                            :error="$errors->first('userPetition.subject')">
                                                            <x-input.text-area wire:model.lazy="userPetition.subject"
                                                                id="subject" type="text" />
                                                        </x-input.group>

                                                    </div>
                                                    <div class="col-span-6 sm:col-span-6">
                                                        <x-input.group label="Observaciones" for="observations"
                                                            clases="col-span-6 sm:col-span-2"
                                                            :error="$errors->first('userPetition.observations')">
                                                            <x-input.text-area
                                                                wire:model.lazy="userPetition.observations"
                                                                id="observations" type="text" />
                                                        </x-input.group>

                                                    </div>
                                                    <div class="col-span-2 sm:col-span-2">

                                                        <label
                                                            class="block text-sm font-medium text-gray-700">Estado</label>


                                                        @if ($userPetition->state_petition == 2)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Pendiente</span>
                                                        @elseif ($userPetition->state_petition == 3)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En
                                                            Proceso</span>
                                                        @elseif ($userPetition->state_petition == 4)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Aprobado</span>
                                                        @elseif ($userPetition->state_petition == 5)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Rechazado</span>
                                                        @elseif ($userPetition->state_petition == 6)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Completado</span>
                                                        @else
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">Cancelada</span>
                                                        @endif


                                                    </div>
                                                    <div class="col-span-6 sm:col-span-2">
                                                        <label class="block text-sm font-medium text-gray-700">Estado
                                                            Proceso</label>

                                                        @if ($userPetition->processing_status == 2)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">En
                                                            Espera</span>
                                                        @elseif ($userPetition->processing_status == 3)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">En
                                                            Proceso</span>
                                                        @elseif ($userPetition->processing_status == 4)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800">Finalizado</span>
                                                        @endif


                                                    </div>
                                                    <div class="col-span-6 sm:col-span-6">

                                                        <label class="block text-sm font-medium text-gray-700">Archivos
                                                            adjuntos</label>

                                                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                                            <ul role="list"
                                                                class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                                                <li
                                                                    class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                                    <div class="flex w-0 flex-1 items-center">
                                                                        <!-- Heroicon name: mini/paper-clip -->
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-6 h-6">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                                        </svg>

                                                                        <span class="ml-2 w-0 flex-1 truncate">imagen
                                                                            solicitud</span>
                                                                    </div>
                                                                    <div class="ml-4 flex-shrink-0">
                                                                        @if ($userPetition)
                                                                        <a href="#"
                                                                            wire:click.prevent="showImagePetitionModal()"
                                                                            class="font-medium text-indigo-600 hover:text-indigo-500">Ver</a>
                                                                        @endif
                                                                    </div>
                                                                </li>
                                                                <li
                                                                    class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                                    <div class="flex w-0 flex-1 items-center">
                                                                        <!-- Heroicon name: mini/paper-clip -->
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-6 h-6">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                                        </svg>

                                                                        <span class="ml-2 w-0 flex-1 truncate">imagen
                                                                            Voucher</span>
                                                                    </div>
                                                                    <div class="ml-4 flex-shrink-0">
                                                                        @if ($userPetition)

                                                                        @if ($userPetition)
                                                                        <a href="#"
                                                                            wire:click.prevent="showImageVoucherModal()"
                                                                            class="font-medium text-indigo-600 hover:text-indigo-500">Ver</a>
                                                                        @endif
                                                                        @endif
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </dd>
                                                    </div>
                                                    @if (!empty($userPetition->courses))
                                                    <div class="col-span-6 sm:col-span-6">
                                                        <label class="block text-sm font-medium text-gray-700">Curso
                                                            solicitado</label>
                                                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                                            <ul role="list"
                                                                class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                                                @if (isset($userPetition->courses) &&
                                                                is_array($userPetition->courses) &&
                                                                !empty($userPetition->courses))
                                                                @forelse ($userPetition->courses as $item)
                                                                <li
                                                                    class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                                    <div class="flex w-0 flex-1 items-center">
                                                                        <!-- Heroicon name: mini/paper-clip -->


                                                                        <span class="ml-2 w-0 flex-1 truncate">{{
                                                                            $item['name'] }}</span>
                                                                    </div>
                                                                    <div class="ml-4 flex-shrink-0">
                                                                        @if ($userPetition)
                                                                        <span
                                                                            class="font-medium text-gray-800 hover:text-gray-700">{{
                                                                            $item['course']['name'] }}</span>
                                                                        @endif
                                                                    </div>
                                                                </li>

                                                                @empty
                                                                <li
                                                                    class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                                    <div class="flex w-0 flex-1 items-center">
                                                                        <!-- Heroicon name: mini/paper-clip -->


                                                                        <span
                                                                            class="ml-2 w-0 flex-1 truncate">Ninguno</span>
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


                                                                        <span
                                                                            class="ml-2 w-0 flex-1 truncate">Ninguno</span>
                                                                    </div>
                                                                    <div class="ml-4 flex-shrink-0">

                                                                    </div>
                                                                </li>
                                                                @endif

                                                            </ul>

                                                        </dd>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                                <x-jet-button wire:click.prevent="save()" wire:loading.attr="disabled"
                                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    Guardar</x-jet-button>
                                            </div> --}}
                                        </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" wire:click.prevent="showRejectModal()"
                            class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center  dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 ">
                            Rechazar
                        </button>
                        <button type="button" wire:click.prevent="ApproveRequest()"
                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center  dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 ">
                            Aprobar
                        </button>


                    </div>
                </div>

            </div>
            @if ($approve)
            <div class="space-y-4 space-x-2">
                <div>
                    <div class="flex justify-between cursor-pointer hover:bg-gray-100  p-2 rounded-md"
                        :class="showForm ? '' : 'bg-gray-50 border-b border-gray-300 shadow-md'"
                        @click="showForm=!showForm">
                        <div class="text-left">
                            <h3 x-cloak x-show="!showForm" class="text-lg font-medium leading-6 text-gray-900">
                                Formulario Subir Records
                            </h3>
                        </div>
                        <div class="text-right">
                            <button x-cloak x-show="showForm" type="button"
                                class="inline-flex items-center rounded-full border border-transparent  text-red-500 shadow-sm hover:text-red-700"
                                title="Ocultar">
                                <!-- Heroicon name: mini/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                                <button x-cloak x-show="!showForm" type="button"
                                    class="inline-flex items-center rounded-full border border-transparent  text-green-500 shadow-sm hover:text-green-700 "
                                    title="Mostrar">
                                    <!-- Heroicon name: mini/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>


                                </button>
                        </div>
                    </div>
                </div>
                <div x-cloak x-show="showForm" x-collapse>

                    <form class="space-y-8 divide-y divide-gray-200 ">
                        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                            <div class="space-y-6 sm:space-y-5">
                                <div>
                                    <label id="listbox-label" class="block text-sm font-medium text-gray-700"
                                        @click="$refs.button.focus()">Curriculas</label>
                                    <div class="relative mt-1">
                                        <button type="button"
                                            class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                            x-ref="button" @keydown.arrow-up.stop.prevent="onButtonClick()"
                                            @keydown.arrow-down.stop.prevent="onButtonClick()" @click="onButtonClick()"
                                            aria-haspopup="listbox" :aria-expanded="showCurriculas" aria-expanded="true"
                                            aria-labelledby="listbox-label">
                                            <span x-text="optionSelected?optionSelected.name:'Selecione una curricula'"
                                                class="block truncate">Tom Cook</span>
                                            <span
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <svg class="h-5 w-5 text-gray-400"
                                                    x-description="Heroicon name: mini/chevron-up-down"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>


                                        <ul x-cloak x-show="showCurriculas" x-collapse
                                            class="scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-200 absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                            x-max="1" @click.away="showCurriculas = false"
                                            x-description="Select popover, show/hide based on select state."
                                            @keydown.enter.stop.prevent="onOptionSelect(),$wire.indexEnterAndSpace(selectedIndex)"
                                            @keydown.space.stop.prevent="onOptionSelect(),$wire.indexEnterAndSpace(selectedIndex)"
                                            @keydown.escape="onEscape()" @keydown.arrow-up.prevent="onArrowUp()"
                                            @keydown.arrow-down.prevent="onArrowDown()" x-ref="listbox" tabindex="-1"
                                            role="listbox" aria-labelledby="listbox-label" "
                                                :aria-activedescendant=" activeDescendant"
                                            aria-activedescendant="listbox-option-3">

                                            @foreach ($curriculaPetitions as $index=> $curricula)
                                            <li x-state:on="Highlighted" x-state:off="Not Highlighted"
                                                class="text-gray-900 relative cursor-default select-none py-2 pl-3 pr-9"
                                                x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                                                :id="'listbox-option-' + {{ $index }}" role="option"
                                                @click="choose({{ $index }}),$wire.curriculaSelect({{ $curricula }})"
                                                @mouseenter="onMouseEnter($event)"
                                                @mousemove="onMouseMove($event,{{ $index }})"
                                                @mouseleave="onMouseLeave($event)" :class="{
                                                        'text-white bg-indigo-600': activeIndex ===
                                                            {{ $index }},
                                                        'text-gray-900': !(activeIndex ===
                                                            {{ $index }})
                                                    }">
                                                <span x-state:on="Selected" x-state:off="Not Selected"
                                                    class="font-normal block truncate" :class="{
                                                            'font-semibold': selectedIndex ===
                                                                {{ $index }},
                                                            'font-normal': !(selectedIndex ===
                                                                {{ $index }})
                                                        }">{{ $curricula['name'] }}
                                                    - {{ $curricula['code'] }}</span>

                                                <span x-description="Checkmark, only display for selected option."
                                                    x-state:on="Highlighted" x-state:off="Not Highlighted"
                                                    class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4"
                                                    :class="{
                                                            'text-white': activeIndex ===
                                                                {{ $index }},
                                                            'text-indigo-600': !(activeIndex ===
                                                                {{ $index }})
                                                        }" x-show="selectedIndex === {{ $index }}">
                                                    <svg class="h-5 w-5" x-description="Heroicon name: mini/check"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                            </li>
                                            @endforeach
                                            {{--
                                            </template> --}}

                                        </ul>

                                    </div>
                                </div>




                                <div class="mt-4 sm:col-span-6 sm:mt-0 space-y-5 space-x-2">
                                    <div>
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Subir Records</h3>
                                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Seleccione el formato del
                                            archivo
                                            estan
                                            los records.</p>
                                    </div>
                                    <div class="flex space-x-6">

                                        <div class="flex items-center">
                                            <input wire:model="showFile" id="excel" value="excel" type="checkbox"
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <label for="excel"
                                                class="ml-3 block text-sm font-medium text-gray-700">Excel</label>
                                        </div>
                                        {{-- <div class="flex items-center">
                                            <input wire:model="showFile" id="pdf" type="radio" value="pdf"
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <label for="pdf"
                                                class="ml-3 block text-sm font-medium text-gray-700">Pdf</label>
                                        </div> --}}

                                    </div>
                                </div>
                                <div class="space-y-6 sm:space-y-5 space-x-2">
                                    <div class="">

                                        @if ($showFile === 'excel')
                                        <div class="items-center ">
                                            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-2">

                                                <!-- Contenedor del ícono y el input -->
                                                <div class="flex items-center space-x-2 text-xl">
                                                    <x-icon.upload class="text-cool-gray-400 h-6 w-6" />
                                                    <x-input.file-upload wire:model="excelRecord" id="upload"
                                                        accept=".xlsx,.xls">
                                                        <span class="text-gray-400 font-bold">xlsx Archivos</span>
                                                    </x-input.file-upload>
                                                    {{-- <div wire:loading wire:target="excelRecord">Uploading...</div>
                                                    --}}
                                                    <div x-cloak x-show="isUploading">

                                                        <p class="text-sm font-medium text-gray-900">subiendo
                                                            archivo...</p>
                                                        <div class="mt-2" aria-hidden="true">
                                                            <div class="overflow-hidden rounded-full bg-gray-200">
                                                                <div class="h-2 rounded-full bg-green-600"
                                                                    :style="'width: ' + progress + '%'"></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Contenedor del nombre y el botón -->
                                                <div class="flex flex-col md:flex-row md:items-center md:space-x-3">
                                                    <span class="text-gray-500 text-sm">{{ $nameUpload }}</span>
                                                    <button wire:click.prevent="uploadExcel"
                                                        class="mt-2 md:mt-0 inline-flex justify-center rounded-md border border-transparent bg-gray-500 py-1.5 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                                        Procesar
                                                    </button>

                                                </div>

                                            </div>


                                            @error('excelRecord')
                                            <div class="mt-3 text-red-500 text-sm ">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                        </div>

                                        {{-- <div class="mt-1 sm:col-span-2 sm:mt-0">
                                            <div class="flex items-center space-x-4">
                                                <x-input.file-upload type="file" wire:model="excelRecord" />
                                                <button
                                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                                    wire:click.prevent="uploadExcel">Subir Excel</button>
                                            </div>
                                        </div> --}}
                                        @elseif($showFile === 'pdf')
                                        <input type="file" wire:model="pdfRecord">
                                        <button
                                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            type="submit">Upload PDF</button>
                                        @else
                                        <span class="text-gray-500 text-sm"> Aún no ha selecionado ningún
                                            archivo</span>
                                        @endif



                                    </div>
                                </div>
                            </div>


                        </div>

                        {{-- <div class="pt-5">
                            <div class="flex justify-end">
                                <button type="button"
                                    class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</button>
                                <button wire:click.prevent="uploadExcel"
                                    class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Guardar</button>
                            </div>
                        </div> --}}
                    </form>
                </div>

            </div>
            <div class="space-y-4 space-x-2">
                <div>
                    <div class="flex justify-between cursor-pointer hover:bg-gray-100  p-2 rounded-md"
                        :class="showForm ? '' : 'bg-gray-50 border-b border-gray-300 shadow-md'"
                        @click="showRecord=!showRecord">
                        <div class="text-left">
                            <h3 x-cloak x-show="!showRecord" class="text-lg font-medium leading-6 text-gray-900">
                                Visualizar Record
                            </h3>
                        </div>
                        <div class="text-right">
                            <button x-cloak x-show="showRecord" type="button"
                                class="inline-flex items-center rounded-full border border-transparent  text-red-500 shadow-sm hover:text-red-700"
                                title="Ocultar">
                                <!-- Heroicon name: mini/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                                <button x-cloak x-show="!showRecord" type="button"
                                    class="inline-flex items-center rounded-full border border-transparent  text-green-500 shadow-sm hover:text-green-700 "
                                    title="Mostrar">
                                    <!-- Heroicon name: mini/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>


                                </button>
                        </div>
                    </div>
                </div>
                <div x-cloak x-show="showRecord" x-collapse>

                    <form class="space-y-8 divide-y divide-gray-200 ">
                        <div class="">
                            <div class="sm:flex sm:items-center">
                                <div class="sm:flex-auto">
                                    <h1 class="text-xl font-semibold text-gray-900">Record</h1>
                                    <p class="mt-2 text-sm text-gray-700">
                                        Una lista de todas las notas del usuario, incluido su codigo, nombre, creditos,
                                        nota y C.
                                    </p>
                                </div>

                                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                    @if (count($resultDataExcel) > 0 && count($backup) == 0)
                                    <button type="button" wire:click.prevent="justOneCourseForArea()"
                                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                                        Mostrar Registros Únicos
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div x-data="{
                                            showRows: {},
                                            showRawsBackup: {},
                                            selectedSvg: null,
                                            isDragging: null,
                                            isUploading: false,
                                            progress: 0,
                                            clearDragging: function() {
                                                this.isDragging = null;
                                            },
                                        
                                        }" class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8 ">
                                        @if (count($backup) == 0)
                                        <div>

                                            <div
                                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                                <table class="min-w-full">
                                                    <thead class="bg-white">
                                                        <tr>
                                                            <th scope="col"
                                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                                N°</th>
                                                            <th scope="col"
                                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                                Código</th>
                                                            <th scope="col"
                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                Curso</th>
                                                            <th scope="col"
                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                Créditos</th>
                                                            <th scope="col"
                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                Nota</th>
                                                            <th scope="col"
                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                Semestre</th>
                                                            <th scope="col"
                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                Tipo</th>

                                                            {{-- <th scope="col"
                                                                class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                                <span class="sr-only">Edit</span>
                                                            </th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white" wire:sortable="updateOrder">

                                                        @php
                                                        $countRaw = 0;
                                                        @endphp
                                                        @forelse ($resultDataExcel as $record =>$courses)
                                                        <div x-data="{ showRows: {} }">
                                                            <tr wire:key="item-{{ $record }}-record"
                                                                class="border-t border-gray-200 cursor-pointer"
                                                                x-init="showRows['{{ $record }}'] = true"
                                                                @click="showRows['{{ $record }}'] = !showRows['{{ $record }}']">
                                                                <th colspan="7" scope="colgroup"
                                                                    class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                                                    {{ mb_strtoupper($record) }}
                                                                </th>
                                                            </tr>
                                                            @foreach ($courses as $item => $course)
                                                            @php
                                                            $countRaw++;
                                                            @endphp
                                                            <tr wire:key="item-{{ $course['codigo'] }}-{{ $course['unique_key_course'] }}"
                                                                x-show="showRows['{{ $record }}']" :class="{
                                                                                    'bg-orange-200': '{{ $course['tipo_curso'] }}'
                                                                                    ===
                                                                                        'electivo',
                                                                                    'bg-yellow-200': '{{ $course['tipo_curso'] }}'
                                                                                    ===
                                                                                        'actividad_libre'
                                                                                }"
                                                                x-transition:enter="transition ease-out duration-300"
                                                                x-transition:enter-start="opacity-0 transform scale-95"
                                                                x-transition:enter-end="opacity-100 transform scale-100"
                                                                x-transition:leave="transition ease-in duration-300"
                                                                x-transition:leave-start="opacity-100 transform scale-100"
                                                                x-transition:leave-end="opacity-0 transform scale-95"
                                                                class="border-t border-gray-300">
                                                                <td
                                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                    {{ $countRaw }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                    {{ strtoupper($course['codigo']) }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                                    {{ strtoupper($course['nombre']) }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                                    {{ strtoupper($course['creditos']) }}
                                                                </td>
                                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                                    :class="{
                                                                                        'bg-red-100': '{{ $course['nota'] }}' <
                                                                                            10.5
                                                                                    }">
                                                                    {{ strtoupper($course['nota']) }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                                    {{ strtoupper($course['semestre']) }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                                    {{ $course['tipo_curso'] ?
                                                                    App\Models\Course::TYPECOURSE[$course['tipo_curso']]
                                                                    : 'no asignado' }}
                                                                </td>


                                                                {{-- <td
                                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                                    <a href="#"
                                                                        class="text-indigo-600 hover:text-indigo-900">Edit<span
                                                                            class="sr-only">, Lindsay Walton</span></a>
                                                                </td> --}}
                                                            </tr>
                                                            @endforeach
                                                        </div>

                                                        @empty
                                                        <tr>
                                                            <td colspan="9">
                                                                <div class="flex justify-center items-center">
                                                                    <x-icon.inbox
                                                                        class="h-8 w-8 text-neutral-400 space-x-2" />
                                                                    <span
                                                                        class="font-medium py-8 text-neutral-500 text-xl">
                                                                        Record de notas no encontrado...
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforelse




                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        @endif
                                        @if (count($backup) > 0)
                                        <div class="space-y-3">


                                            <div
                                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                                <table class="min-w-full">
                                                    <thead class="bg-white">
                                                        <tr>
                                                            <th scope="col"
                                                                class="py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                            </th>
                                                            <th scope="col"
                                                                class="py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                                N°</th>


                                                            <th scope="col"
                                                                class="py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                                Código</th>

                                                            <th scope="col"
                                                                class="px-3 py-2 text-left text-sm font-semibold text-gray-900">
                                                                Curso</th>
                                                            <th scope="col"
                                                                class="px-3 py-2 text-left text-sm font-semibold text-gray-900">
                                                                Créditos</th>
                                                            <th scope="col"
                                                                class="px-3 py-2 text-left text-sm font-semibold text-gray-900">
                                                                Nota</th>
                                                            <th scope="col"
                                                                class="px-3 py-2 text-left text-sm font-semibold text-gray-900">
                                                                Semestre</th>
                                                            <th scope="col"
                                                                class="px-3 py-2 text-left text-sm font-semibold text-gray-900">
                                                                Tipo</th>

                                                            {{-- <th scope="col"
                                                                class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                                <span class="sr-only">Edit</span>
                                                            </th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white" wire:sortable="updateOrder">
                                                        @php
                                                        $countRaw2 = 0;
                                                        @endphp

                                                        @forelse ($backup as $record =>$courses)
                                                        <div x-data="{
                                                                        showRawsBackup: {}
                                                                    
                                                                    }">

                                                            <tr wire:key="item-{{ $record }}-buckup"
                                                                class="border-t border-gray-200 cursor-pointer"
                                                                x-init="showRawsBackup['{{ $record }}'] = true"
                                                                @click="showRawsBackup['{{ $record }}'] = !showRawsBackup['{{ $record }}']">
                                                                <th colspan="8" scope="colgroup"
                                                                    class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                                                    {{ mb_strtoupper($record) }}
                                                                </th>
                                                            </tr>

                                                            @foreach ($courses as $item => $course)
                                                            @php
                                                            $countRaw2++;
                                                            @endphp

                                                            <tr wire:key="{{ $course['unique_key_course'] }}"
                                                                wire:sortable.item="{{ $course['unique_key_course'] }}"
                                                                {{-- @mouseenter="isDragging = '{{$course['id']}}'" --}}
                                                                x-show="showRawsBackup['{{ $record }}']" :class="{
                                                                                    'bg-orange-200': '{{ $course['tipo_curso'] }}'
                                                                                    ===
                                                                                        'electivo',
                                                                                    'bg-yellow-200': '{{ $course['tipo_curso'] }}'
                                                                                    ===
                                                                                        'actividad_libre',
                                                                                    'bg-yellow-50': isDragging ===
                                                                                        '{{ $course['unique_key_course'] }}'
                                                                                }"
                                                                x-transition:enter="transition ease-out duration-300"
                                                                x-transition:enter-start="opacity-0 transform scale-95"
                                                                x-transition:enter-end="opacity-100 transform scale-100"
                                                                x-transition:leave="transition ease-in duration-300"
                                                                x-transition:leave-start="opacity-100 transform scale-100"
                                                                x-transition:leave-end="opacity-0 transform scale-95"
                                                                class="border-t border-gray-300">
                                                                <td class="whitespace-nowrap cursor-pointer py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                                    @dragstart="isDragging = '{{ $course['unique_key_course'] }}'"
                                                                    wire:sortable.handle
                                                                    @mousedown="$wire.handleDrop('{{ $course['unique_key_course'] }}'),isDragging = '{{ $course['unique_key_course'] }}',selectedSvg='{{ $course['unique_key_course'] }}'"
                                                                    @mouseup="clearDragging(),selectedSvg = null" {{--
                                                                    @mouseleave="clearDragging()" --}}>


                                                                    <svg x-show="selectedSvg == '{{ $course['unique_key_course'] }}'"
                                                                        :class="{
                                                                                            'font-bold text-gray-900': selectedSvg ==
                                                                                                '{{ $course['unique_key_course'] }}'
                                                                                        }"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-4 h-4">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d=" M9 9V4.5M9 9H4.5M9 9L3.75
                                                                                    3.75M9 15v4.5M9 15H4.5M9 15l-5.25
                                                                                    5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15
                                                                                    15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                                                                    </svg>
                                                                    <svg x-show="selectedSvg !== '{{ $course['unique_key_course'] }}'"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-4 h-4">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                                                    </svg>

                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap  py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                    {{ $countRaw2 }}
                                                                </td>

                                                                <td
                                                                    class="whitespace-nowrap  py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                    {{ strtoupper($course['codigo']) }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-3  py-2 text-sm text-gray-500">
                                                                    {{ strtoupper($course['nombre']) }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-3  py-2 text-sm text-gray-500">
                                                                    {{ strtoupper($course['creditos']) }}
                                                                </td>
                                                                <td class="whitespace-nowrap px-3  py-2 text-sm text-gray-500"
                                                                    :class="{
                                                                                        'bg-red-100': '{{ $course['nota'] }}' <
                                                                                            10.5
                                                                                    }">
                                                                    {{ strtoupper($course['nota']) }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-3  py-2 text-sm text-gray-500">
                                                                    {{ $course['semestre'] }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-3  py-2 text-sm text-gray-500">
                                                                    {{ $course['tipo_curso'] ?
                                                                    App\Models\Course::TYPECOURSE[$course['tipo_curso']]
                                                                    : 'no asignado' }}
                                                                </td>


                                                            </tr>
                                                            @endforeach


                                                            @empty
                                                            <tr>
                                                                <td colspan="9">
                                                                    <div class="flex justify-center items-center">
                                                                        <x-icon.inbox
                                                                            class="h-8 w-8 text-neutral-400 space-x-2" />
                                                                        <span
                                                                            class="font-medium py-8 text-neutral-500 text-xl">
                                                                            Record de notas no encontrado...
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforelse




                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="">

                                                <div class="mt-8 flex flex-col">
                                                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                        <div class="inline-block  py-2 align-middle md:px-6 lg:px-8">
                                                            <div
                                                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                                                @if (!empty($totalCreditsForAreaCurrentCurricula))
                                                                <table class="table-auto divide-y divide-gray-300">
                                                                    <thead class="bg-gray-50">
                                                                        <tr>
                                                                            <th scope="col"
                                                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                                                Área Academica</th>
                                                                            <th scope="col"
                                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                Cred. Exigib</th>
                                                                            <th scope="col"
                                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                Cred. Aprobados</th>
                                                                            <th scope="col"
                                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                Observaciones</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="divide-y divide-gray-200 bg-white">
                                                                        @foreach ($totalCreditsForAreaCurrentCurricula
                                                                        as $area)
                                                                        <tr wire:key="{{ $area['name'] }}">
                                                                            <td
                                                                                class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                                {{ mb_strtoupper($area['name']) }}
                                                                            </td>
                                                                            <td
                                                                                class="text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ $area['total_credits'] }}
                                                                            </td>
                                                                            <td
                                                                                class="text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ $area['total_credits_excel'] }}
                                                                            </td>
                                                                            <td
                                                                                class="text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                --
                                                                            </td>

                                                                        </tr>
                                                                        @endforeach

                                                                        <tr wire:key="{{ $area['name'] }}">
                                                                            <td
                                                                                class=" text-center whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                                Total
                                                                            </td>
                                                                            <td
                                                                                class="text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ $total_credits_obligated }}
                                                                            </td>

                                                                            <td
                                                                                class="text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ $total_credits_excel }}
                                                                            </td>

                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (isset($missingCoursesPair) && !empty($missingCoursesPair))
                                            <div class="">
                                                <div class="sm:flex sm:items-center">
                                                    <div class="sm:flex-auto">
                                                        <h1 class="text-base font-semibold text-gray-900">
                                                            CURSOS
                                                            DEL PARES</h1>
                                                    </div>
                                                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                                    </div>
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                        <div class="inline-block  py-2 align-middle md:px-6 lg:px-8">
                                                            <div
                                                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">



                                                                <table class=" divide-y divide-gray-300">
                                                                    <thead class="bg-gray-50">
                                                                        <tr>
                                                                            <th scope="col"
                                                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                                                CODIGO</th>
                                                                            <th scope="col"
                                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                CURSO</th>
                                                                            <th scope="col"
                                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                CREDITOS</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="divide-y divide-gray-200 bg-white">
                                                                        @foreach ($missingCoursesPair as $coursePair)
                                                                        <tr
                                                                            wire:key="pairCourse-{{ $coursePair['code'] }}">
                                                                            <td
                                                                                class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                                {{ mb_strtoupper($coursePair['code']) }}
                                                                            </td>
                                                                            <td
                                                                                class=" whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ mb_strtoupper($coursePair['name']) }}
                                                                            </td>
                                                                            <td
                                                                                class=" text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ $coursePair['credits'] }}
                                                                            </td>

                                                                        </tr>
                                                                        @endforeach

                                                                        <tr wire:key="{{ $area['name'] }}">
                                                                            <td colspan="2"
                                                                                class=" text-right whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                                Total
                                                                            </td>

                                                                            <td
                                                                                class="text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ $sumPairCourseCredits }}
                                                                            </td>

                                                                        </tr>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if (isset($missingCoursesOdd) && !empty($missingCoursesOdd))
                                            <div class="">
                                                <div class="sm:flex sm:items-center">
                                                    <div class="sm:flex-auto">
                                                        <h1 class="text-base font-semibold text-gray-900">
                                                            CURSOS
                                                            DEL IMPARES</h1>
                                                    </div>
                                                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                                    </div>
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                        <div class="inline-block  py-2 align-middle md:px-6 lg:px-8">
                                                            <div
                                                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">



                                                                <table class=" divide-y divide-gray-300">
                                                                    <thead class="bg-gray-50">
                                                                        <tr>
                                                                            <th scope="col"
                                                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                                                CODIGO</th>
                                                                            <th scope="col"
                                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                CURSO</th>
                                                                            <th scope="col"
                                                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                CREDITOS</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="divide-y divide-gray-200 bg-white">
                                                                        @foreach ($missingCoursesOdd as $courseOdd)
                                                                        <tr
                                                                            wire:key="oddCourse-{{ $courseOdd['code'] }}">
                                                                            <td
                                                                                class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                                {{ mb_strtoupper($courseOdd['code']) }}
                                                                            </td>
                                                                            <td
                                                                                class=" whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ mb_strtoupper($courseOdd['name']) }}
                                                                            </td>
                                                                            <td
                                                                                class=" text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ $courseOdd['credits'] }}
                                                                            </td>

                                                                        </tr>
                                                                        @endforeach

                                                                        <tr wire:key="{{ $area['name'] }}">
                                                                            <td colspan="2"
                                                                                class=" text-right whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                                Total
                                                                            </td>

                                                                            <td
                                                                                class="text-center whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                                                                                {{ $sumOddCourseCredits }}
                                                                            </td>

                                                                        </tr>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div>
                                                <label class="text-base font-medium text-gray-900">Cumple los
                                                    requerimientos</label>
                                                <p class="text-sm leading-5 text-gray-500">¿El usuario cumple con
                                                    los requerimientos?</p>
                                                <fieldset class="mt-4">
                                                    <legend class="sr-only">Cumple los Requerimientos</legend>
                                                    <div
                                                        class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                                        <div class="flex items-center">
                                                            <input id="si-cumple" name="cumple-requerimiento"
                                                                wire:click="processRequestMeet" type="radio"
                                                                wire:model="meetsRequirements" value="yes"
                                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                            <label for="si-cumple"
                                                                class="ml-3 block text-sm font-medium text-gray-700">Si
                                                                cumple</label>
                                                        </div>

                                                        <div class="flex items-center">
                                                            <input id="no-cumple" name="cumple-requerimiento"
                                                                wire:click="processRequestMeet" type="radio"
                                                                wire:model="meetsRequirements" value="no"
                                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                            <label for="no-cumple"
                                                                class="ml-3 block text-sm font-medium text-gray-700">No
                                                                cumple</label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        @if (!empty($articles))
                                        <div class="space-y-2 mt-2">
                                            @foreach ($articles as $index => $article)
                                            <div>
                                                <label for="item_{{$index}}_description"
                                                    class="block text-sm font-medium text-gray-700">{{ $article['name']
                                                    }}</label>
                                                <div class="mt-1">
                                                    <textarea wire:model.defer="articles.{{ $index }}.description"
                                                        wire:key="article-{{ $index }}" rows="3"
                                                        name="item-{{ $index }}-description"
                                                        id="item_{{$index}}_description"
                                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                                </div>
                                                <p class=" text-sm text-gray-500">Sientese libre de completar el {{
                                                    $article['name'] }} </p>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="pt-5">
                            <div class="flex justify-end space-x-2">
                                <button type="button" wire:click="back()"
                                    class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Cancelar
                                </button>
                                {{-- <button type="button" wire:click="generarDocumentoWord"
                                    class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Generar Documento
                                </button> --}}

                                <button @click.prevent="openModalConfirm = true"
                                    class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            @endif
        </div>
        <!--modal alert!-->
        <div>
            <div x-cloak x-data="{ open:@entangle('modalRejectRequest')}" @keydown.window.escape="open = false"
                class="relative z-10" x-show="open" aria-labelledby="modal-title" role="dialog" aria-modal="true">

                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                        <div
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                        Rechazar
                                        Solicitud</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">¿Estás seguro de que deseas rechazar la
                                            solicitd?
                                            Esta acción no se puede deshacer.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="button"
                                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                    wire:click="rejectRequest()">Rechazar</button>
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
        {{-- modal accept save --}}
        <div >


            <div x-cloak @keydown.window.escape="openModalConfirm = false" x-show="openModalConfirm" class="relative z-10"
                aria-labelledby="modal-title" x-ref="dialog" aria-modal="true">

                <div x-show="openModalConfirm" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    x-description="Background backdrop, show/hide based on modal state."
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>


                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                        <div x-show="openModalConfirm" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-description="Modal panel, show/hide based on modal state."
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                            @click.away="openModalConfirm = false">
                            <div>
                                <div
                                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                    <svg class="h-6 w-6 text-green-600" x-description="Heroicon name: outline/check"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5">
                                        </path>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Acción requerida </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            @if ($userPetition->agreement_number)
                                            ¿Desea reescribir los datos y guardarlos, actualizando la información existente?
                                            
                                            @else
                                            ¿Desea aguardar la información?
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                <button type="button"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm"
                                    wire:click.prevent="save()">Confirmar</button>
                                <button type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm"
                                    @click="openModalConfirm = false">Cancelar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
        {{-- end modal accept save --}}
    </main>
    <form>
        <x-modal.dialog maxWidth="4xl" wire:model="showImagePetition">

            <x-slot name="title">

            </x-slot>


            <x-slot name="content">

                <div
                    class="group aspect-w-2 aspect-h-1 overflow-hidden rounded-lg sm:aspect-h-1 sm:aspect-w-1 sm:row-span-2">
                    <img src="{{ asset($imagenShowModal) }}" alt="imagen de los archivos adjuntos"
                        class="object-cover object-center ">
                    <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50"></div>
                    <div class="flex items-end p-6 sticky-top">
                        <div>
                            <h3 class="font-semibold text-white">
                                <a href="#" wire:click.prevent="downloadImagePetition()">
                                    <span class=" inset-0"></span>
                                    Descargar
                                </a>
                            </h3>
                            <p aria-hidden="true" class="mt-1 text-sm text-white">
                                {{ $userPetition->user_petition->name }} {{ $userPetition->user_petition->surname }}
                            </p>
                        </div>
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">

                <x-button.danger wire:click="$set('showImagePetition', false)">Cerrar</x-button.danger>
                {{-- <x-button.success wire:click.prevent="save">Descargar</x-button.success> --}}

            </x-slot>

        </x-modal.dialog>
    </form>

</div>