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
                <form class="flex w-full md:ml-0" action="#" method="GET">
                    <label for="search-field" class="sr-only">Search</label>
                    <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">
                            <!-- Heroicon name: mini/magnifying-glass -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="search-field" name="search-field"
                            class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
                            placeholder="Search" type="search">
                    </div>
                </form>
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
    <!--main-->
    <main class=" pb-10 lg:py-12 lg:px-8  space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Solicitud
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
            </div>
        </div>
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5 ">

            <div class="overflow-hidden bg-white  sm:rounded-md lg:col-span-12 space-y-6">
                <div class="">
                    <h4 class="text-xl font-bold leading-7 text-gray-500 sm:truncate sm:text-xl sm:tracking-tight">
                        Completar Formulario
                    </h4>
                    <div class="flex items-center text-sm text-gray-500">

                        Todos los campos son obligatorios <span class="ml-2 text-red-500">(*) </span>
                    </div>
                </div>
                <div class="space-y-4 px-2">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1 overflow-auto ">
                            <div>
                                <h4
                                    class="text-sm font-bold leading-7 text-gray-700 sm:truncate sm:text-sm sm:tracking-tight">
                                    {{ strtoupper($petition->name) }}

                                </h4>
                            </div>
                        </div>
                        <div class="col-span-2 overflow-auto  text-right">
                            @if ($petition->state == 1)
                            <span
                                class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Disponible</span>
                            @else
                            <span
                                class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">No
                                Disponible</span>
                            @endif

                        </div>
                        <div class="col-span-1 overflow-auto ">
                            <div>

                                <div class="flex items-center text-sm text-gray-700">

                                    <x-input.group for="codePetition" label="Código" clases="col-span-6 sm:col-span-4"
                                        :error="$errors->first('codePetition')">
                                        <x-input.text type="text" wire:model.defer="codePetition" id="codePetition"
                                            placeholder="0055766" />
                                    </x-input.group>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-1 overflow-auto ">
                            <h4
                                class="text-sm font-bold leading-7 text-gray-500 sm:truncate sm:text-sm sm:tracking-tight">
                                Tipo de Trámite

                            </h4>
                            <div class="flex items-center text-sm text-gray-700 mt-2">

                                Solicitud
                            </div>
                        </div>
                        <div class="col-span-1overflow-auto ">

                        </div>
                    </div>
                    <div>
                        <div class="col-span-1overflow-auto ">
                            <x-input.group for="subjectPetition" label="Asunto" clases="col-span-6 sm:col-span-4"
                                :error="$errors->first('subjectPetition')">
                                <x-input.text-area type="text" wire:model.defer="subjectPetition" id="subjectPetition" />
                            </x-input.group>
                        </div>
                    </div>
                    <div class="space-x-3">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-xl font-semibold text-gray-900">Lisa de requisitos</h1>
                                {{-- <p class="mt-2 text-sm text-gray-700">.</p> --}}
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <button type="button" wire:click.prenvent.once="save"
                                    class="inline-flex items-center  justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                                    wire:loading.attr="disabled">Solicitar</button>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col space-y-4">
                            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">

                                        <x-table clasesBody="'bg-white'">

                                            <x-slot name="head">
                                                <x-table.heading class="text-left bg-white">
                                                    Nº
                                                </x-table.heading>
                                                <x-table.heading class="text-left bg-white">
                                                    Nombre
                                                </x-table.heading>
                                                <x-table.heading class="text-left bg-white">

                                                </x-table.heading>
                                                <x-table.heading class="text-left bg-white">

                                                </x-table.heading>
                                            </x-slot>
                                            <x-slot name="body">
                                                <x-table.row
                                                    class="transition-colors duration-300 {{ $nameUploadPetition ? 'border border-green-400' : '' }}">
                                                    <x-table.cell>
                                                        1
                                                    </x-table.cell>
                                                    <x-table.cell>
                                                        Solicitud
                                                    </x-table.cell>
                                                    <x-table.cell>
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                            Obligatorio
                                                        </span>
                                                    </x-table.cell>
                                                    <x-table.cell>



                                                        <div x-data="{ isUploading: false, progress: 0 }"
                                                            x-on:livewire-upload-start="isUploading = true"
                                                            x-on:livewire-upload-finish="isUploading = false"
                                                            x-on:livewire-upload-error="isUploading = false"
                                                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                            class=" flex flex-col items-center justify-center space-y-2 ">
                                                            <div class="flex items-center space-x-2 text-xl">

                                                                <x-input.file-upload wire:model="imagePetition"
                                                                    accept="image/png,image/jpeg" id="imagePetition">
                                                                </x-input.file-upload>
                                                                @if (strlen($nameUploadPetition) > 0)
                                                                <div>
                                                                    {{-- <span class="text-gray-500 text-sm">{{
                                                                        $nameUploadPetition }}</span> --}}
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor"
                                                                        class="w-6 h-6 text-green-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>

                                                                </div>
                                                                @endif
                                                            </div>
                                                            @error('imagePetition')
                                                            <div class="mt-3 text-red-500 text-sm">{{ $message }}
                                                            </div>
                                                            @enderror
                                                            <div x-cloak x-show="isUploading">

                                                                <p class="text-sm font-medium text-gray-900">subiendo
                                                                    imagen...</p>
                                                                <div class="mt-2" aria-hidden="true">
                                                                    <div
                                                                        class="overflow-hidden rounded-full bg-gray-200">
                                                                        <div class="h-2 rounded-full bg-green-600"
                                                                            :style="'width: ' + progress + '%'"></div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </x-table.cell>
                                                </x-table.row>
                                                <x-table.row
                                                    class="transition-colors duration-300 {{ $nameUploadVoucher ? 'border border-green-400' : '' }}">
                                                    <x-table.cell>
                                                        2
                                                    </x-table.cell>
                                                    <x-table.cell>
                                                        Recibo
                                                    </x-table.cell>
                                                    <x-table.cell>
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                            Obligatorio
                                                        </span>
                                                    </x-table.cell>
                                                    <x-table.cell>
                                                        <div x-data="{ isUploading: false, progress: 0 }"
                                                            x-on:livewire-upload-start="isUploading = true"
                                                            x-on:livewire-upload-finish="isUploading = false"
                                                            x-on:livewire-upload-error="isUploading = false"
                                                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                            class=" flex flex-col items-center justify-center space-y-2 ">
                                                            <div class="flex items-center space-x-2 text-xl">

                                                                <x-input.file-upload wire:model="imageVoucher"
                                                                    accept="image/png,image/jpeg" id="imageVoucher">
                                                                </x-input.file-upload>
                                                                @if (strlen($nameUploadVoucher) > 0)
                                                                <div>
                                                                    {{-- <span class="text-gray-500 text-sm">{{
                                                                        $nameUploadVoucher }}</span> --}}
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor"
                                                                        class="w-6 h-6 text-green-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>


                                                                </div>
                                                                @endif

                                                            </div>
                                                            @error('imageVoucher')
                                                            <div class="mt-3 text-red-500 text-sm">{{ $message }}
                                                            </div>
                                                            @enderror
                                                            <div x-cloak x-show="isUploading">

                                                                <p class="text-sm font-medium text-gray-900">subiendo
                                                                    imagen...</p>
                                                                <div class="mt-2" aria-hidden="true">
                                                                    <div
                                                                        class="overflow-hidden rounded-full bg-gray-200">
                                                                        <div class="h-2 rounded-full bg-green-600"
                                                                            :style="'width: ' + progress + '%'"></div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </x-table.cell>
                                                </x-table.row>

                                            </x-slot>

                                        </x-table>

                                    </div>
                                </div>
                            </div>
                            @if ((strtolower($petition->name) == 'paralelo' || strtolower($petition->name) ==
                            'dirigido') && count($courses)>0)


                            <div x-data="select({
                                    data: {{ json_encode($courses) }},
                                    option: {{ $course }}, // Enlaza la variable de Livewire curriculas
                                    modelName: 'selected',
                                    showCurriculas: true,
                                    selectedIndex: 0,
                                    activeIndex: 0,
                                
                                
                                })" x-init="init()">
                                <label id="listbox-label" class="block text-sm font-medium text-gray-700"
                                    @click="$refs.button.focus()">
                                    @if (count($courseSelect) == 0)
                                    Seleccione el curso pre requisito
                                    @else
                                    Seleccion el curso principal a solicitar
                                    @endif

                                </label>
                                <div class="relative mt-1">
                                    <button type="button"
                                        class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                        x-ref="button" @keydown.arrow-up.stop.prevent="onButtonClick()"
                                        @keydown.arrow-down.stop.prevent="onButtonClick()" @click="onButtonClick()"
                                        aria-haspopup="listbox" :aria-expanded="showCurriculas" aria-expanded="true"
                                        aria-labelledby="listbox-label">
                                        <span x-text="optionSelected?optionSelected.name:'Selecione un curso'"
                                            class="block truncate">Seleccione</span>
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

                                    <ul x-cloak x-show="showCurriculas"
                                        class="scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-200 absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                        x-max="1" @click.away="showCurriculas = false"
                                        x-description="Select popover, show/hide based on select state."
                                        @keydown.enter.stop.prevent="onOptionSelect(),$wire.indexEnterAndSpace(selectedIndex)"
                                        @keydown.space.stop.prevent="onOptionSelect(),$wire.indexEnterAndSpace(selectedIndex)"
                                        @keydown.escape="onEscape()" @keydown.arrow-up.prevent="onArrowUp()"
                                        @keydown.arrow-down.prevent="onArrowDown()" x-ref="listbox" tabindex="-1"
                                        role="listbox" aria-labelledby="listbox-label"
                                        :aria-activedescendant=" activeDescendant"
                                        aria-activedescendant="listbox-option-3">
                                        {{-- <template x-for="(option, index) in options" :key="index" x-el="ul">
                                            --}}
                                            @foreach ($courses as $index => $courseItem)
                                            <li x-state:on="Highlighted" x-state:off="Not Highlighted"
                                                class="text-gray-900 relative cursor-default select-none py-2 pl-3 pr-9"
                                                x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                                                :id="'listbox-option-' + {{ $index }}" role="option"
                                                @click="choose({{ $index }}),$wire.courseSelectAdd({{ $courseItem }})"
                                                @mouseenter="onMouseEnter($event)"
                                                @mousemove="onMouseMove($event,{{ $index }})"
                                                @mouseleave="onMouseLeave($event)" :class="{ 'text-white bg-indigo-600': activeIndex ===
                                                        {{ $index }}, 'text-gray-900': !(activeIndex ===
                                                            {{ $index }}) }">
                                                <span x-state:on="Selected" x-state:off="Not Selected"
                                                    class="font-normal block truncate" :class="{ 'font-semibold': selectedIndex ===
                                                            {{ $index }}, 'font-normal': !(selectedIndex ===
                                                                {{ $index }}) }">{{ $courseItem['name'] }}
                                                    - {{ $courseItem['code'] }}</span>

                                                <span x-description="Checkmark, only display for selected option."
                                                    x-state:on="Highlighted" x-state:off="Not Highlighted"
                                                    class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4"
                                                    :class="{ 'text-white': activeIndex ===
                                                            {{ $index }}, 'text-indigo-600': !(activeIndex ===
                                                                {{ $index }}) }"
                                                    x-show="selectedIndex === {{ $index }}">
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
                                @error('courseSelect')
                                <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>@enderror
                            </div>
                            @if (count($courseSelect))
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full">
                                    <thead class="bg-white">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                Codigo</th>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                nombre</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($courseSelect as $index => $course)
                                        <tr class="border-t border-gray-300">

                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                {{ strtoupper($course['name']) }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ strtoupper($course['course']['name']) }} -
                                                {{ strtoupper($course['course']['code']) }}
                                            </td>


                                            <td
                                                class="relative whitespace-nowrap text-center  text-sm font-medium sm:pr-6">
                                                <a href="#" wire:click.prevent="removeCourse({{ $index }})"
                                                    class="text-red-600 hover:text-red-900">Quitar<span></span>
                                                </a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>



                </div>


                <!--show form-->
                {{-- @json($petition) --}}
            </div>

        </div>
    </main>
    <!--end main-->
</div>