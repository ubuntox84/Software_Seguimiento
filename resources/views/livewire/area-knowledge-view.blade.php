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
                        <x-input.text wire:model.defer="filters.search" name="search_mobil"
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
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Cursos</h1>
            </div>
            {{-- <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <button type="button" @click="showFormCreate=true"
                    class="order-0 inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:order-1 sm:ml-3">
                    Agregar Curricula
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
                            <x-button.link class="ml-2 text-blue-600" wire:click.prevent="toggleShowFilters">
                                @if ($showFilters)
                                Ocultar
                                @endIf
                                Busqueda avanzada...
                            </x-button.link>
                        </div>
                        <div>
                            <x-input.group borderless paddingless for="perPage" label="">
                                <x-input.select wire:model.defer="perPage" id="perPage">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="50">100</option>
                                </x-input.select>
                            </x-input.group>
                        </div>

                        <div class="col-span-2 mt-2 w-full">
                            <x-button.success class="w-full" wire:click="create">
                                <x-icon.plus /> Nuevo
                            </x-button.success>
                        </div>
                        <div class="col-span-2  mt-1">
                            <x-dropdown label="Acciones ">
                                <x-dropdown.item type="button" wire:click="exportSelected"
                                    class="flex items-center space-x-2">
                                    <x-icon.download class="text-gray-400" /> <span>Exportar área de conocimiento
                                    </span>
                                </x-dropdown.item>
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
                    <div class="mt-2 mb-2 text-sm grid grid-cols-5 gap-2 ">
                        <div class="col-span-6 sm:col-span-2">
                            <x-input.group borderless paddingless for="perPage2" label="Currículo" id="curricula_id">
                                <x-input.select wire:model="curricula_id" addClass="w-3/4" id="perPage2">
                                    <option value="" disabled>Seleccione un Currículo</option>
                                    @foreach ($curriculas as $curricula)
                                    <option value="{{ $curricula->id }}" @if ($curricula->state) class="bg-green-200"
                                        @endif>
                                        {{ $curricula->name }} - {{ $curricula->resolution }} - @if ($curricula->state)
                                        Vigente
                                        @else
                                        No Vigente
                                        @endif
                                    </option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>

                        </div>
                    </div>
                    <div class="flex justify-between  ">
                        <div class=" flex w-full lg:w-2/4 md:w-2/4 space-x-4">
                            <x-input.text wire:model.defer="filters.search" addClass="w-1/2" name="search"
                                placeholder="Buscar" type="search" wire:keydown.enter="searchAreaCourse" />
                            <x-button.link class="text-blue-600 focus:text-blue-800"
                                wire:click.prevent="toggleShowFilters">
                                @if ($showFilters)
                                Ocultar
                                @endIf
                                Búsqueda avanzada...
                            </x-button.link>
                        </div>
                        <div class="space-x-2 flex items-center">
                            <x-dropdown label="Acciones ">
                                <x-dropdown.item type="button" wire:click="exportSelected"
                                    class="flex items-center space-x-2">
                                    <x-icon.download class="text-blue-700" /><span>Exportar Área</span>
                                </x-dropdown.item>
                                <x-dropdown.item type="button" wire:click="exportCurso"
                                    class="flex items-center space-x-2">
                                    <x-icon.download class="text-blue-700" /> <span>Exportar Curso </span>
                                </x-dropdown.item>
                                <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')"
                                    class="flex items-center space-x-2">
                                    <x-icon.trash class="text-red-500" /> <span>Eliminar</span>
                                </x-dropdown.item>
                            </x-dropdown>
                            <livewire:import-courses :curricula_id="$curricula_id" />
                            <x-dropdown label="nuevo">
                                <x-dropdown.item type="button" wire:click="create" class="flex items-center space-x-2">
                                    <x-icon.plus class="text-green-700" /> <span>Nueva Área</span>
                                </x-dropdown.item>
                                <x-dropdown.item type="button" wire:click="createCourse"
                                    class="flex items-center space-x-2">
                                    <x-icon.plus class="text-green-700" /> <span>Nuevo Curso</span>
                                </x-dropdown.item>
                                <x-dropdown.item type="button" wire:click="assignCourseArea"
                                    class="flex items-center space-x-2">
                                    <x-icon.plus class="text-green-700" /> <span>Asignar curso a Área </span>
                                </x-dropdown.item>
                            </x-dropdown>
                            <div class="lg:pl-3 lg:mb-2">
                                <x-icon.updated class="text-gray-600  h-6 w-6 cursor-pointer hover:text-gray-400"
                                    stroke-width="2.5" wire:click="render" wire:loading.class="animate-spin">
                                </x-icon.updated>
                            </div>
                        </div>
                    </div>
                </div>
                <!--busqueda avanzada-->
                <div class="mx-4 md:mx-0">
                    @if ($showFilters)
                    <div class="bg-gray-200 p-4 rounded mt-6 shadow-inner flex relative">
                        <div class="w-1/2 pr-2 space-y-4">

                            <x-input.group for="type_course" label="Tipo de curso" clases="col-span-6 sm:col-span-3"
                                :error="$errors->first('course.type_course')">
                                <x-input.select wire:model="filters.type_course" id="type_courses">
                                    <option value="" disabled selected>por tipo de curso</option>
                                    @foreach (App\Models\Course::TYPECOURSE as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                            <x-input.group for="university_law" label="Ley Universitaria"
                                clases="col-span-6 sm:col-span-3" :error="$errors->first('course.university_law')">
                                <x-input.select wire:model="filters.university_law" id="university_laws">
                                    <option value="" selected disabled>por ley universitario</option>
                                    @foreach (App\Models\Course::UNIVERSITYLAW as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
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
                <!--Curricula Table-->
                <div class="-my-2 mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">

                    {{-- @json($courses) --}}
                    <div class="space-y-4 mb-6 inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <!--Table course-->
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full">
                                <thead class="bg-white">
                                    <tr>
                                        <th
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            <input id="selectPagea" type="checkbox" wire:model="selectPage"
                                                name="selectPagea"
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Código
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            wire:click="sortBy('resolution')">Nombre</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"> Tipo de
                                            Curso</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Opciones</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($courses
                                    ->whereNotNull('areaKnowledges.name')
                                    ->groupBy('areaKnowledges.id') as $area
                                    )

                                    <tr class="border-t border-gray-200">
                                        <th
                                            class="bg-gray-50 px-6 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">


                                            <input wire:model.defer="selected" name="selected"
                                                value="{{ $area->first()->areaKnowledges->id }}" type="checkbox"
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </th>
                                        <th colspan="3"
                                            class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-3">
                                            {{ mb_strtoupper($area->first()->areaKnowledges->name) }}
                                        </th>
                                        <th
                                            class="bg-gray-50 px-4 py-2 justify-end text-left text-sm font-semibold text-gray-900 sm:px-6">
                                            <div class=" text-right">
                                                <button class=" text-blue-700  hover:bg-blue-200 active:bg-blue-700"
                                                    wire:click.defer="edit({{ $area->first()->areaKnowledges->id }})">
                                                    <svg class=" h-5 w-5    group-hover:text-blue-500"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path
                                                            d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                                        <path
                                                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                    </tr>
                                    @foreach ($area as $course)
                                    <tr class="border-t border-gray-300">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            <input
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                type="checkbox" wire:model.defer="selectedCourses"
                                                value="{{ $course->id }}" name="{{ $course->id }}-selectedCourses" />
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ mb_strtoupper($course->code) }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ mb_strtoupper($course->name) }}
                                        </td>


                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $typecourse = $course->type_course ?
                                            App\Models\Course::TYPECOURSE[$course->type_course] : 'no asignado' }}
                                        </td>


                                        <td class=" whitespace-nowrap py-4 pl-3 text-right text-sm font-medium sm:pr-6">
                                            <div class="space-x-2 justify-end flex">

                                                <button type="button" wire:click.defer="editCourse({{ $course->id }})"
                                                    class="text-yellow-500  hover:bg-yellow-200 active:bg-yellow-700'">
                                                    <svg class=" h-5 w-5    group-hover:text-yellow-500"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path
                                                            d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                                        <path
                                                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                                    </svg>
                                                </button>



                                                <button wire:click="showModalPreR({{ $course->id }})"
                                                    class="text-green-700  hover:bg-green-200 active:bg-green-700' flex items-center space-x-2">
                                                    <svg class="inline-block w-5 h-5" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
                                                        </path>
                                                    </svg>
                                                </button>



                                                <button class=" text-blue-700  hover:bg-blue-200 active:bg-blue-700"
                                                    wire:click.defer="showDetailCourse({{ $course->id }})">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @empty
                                    <tr>
                                        <td colspan="10">
                                            <div class="flex justify-center items-center">
                                                <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                                <span class="font-medium py-8 text-neutral-500 text-xl">
                                                    datos no encontrados...
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
            </div>
            <!--Edit And Create Area Modal-->
            <form x-data="{ area: false }">
                <x-modal.dialog maxWidth="4xl" wire:model.defer="showEditModal">
                    <x-slot name="title">Área de Conocimiento
                        <div class="inline">
                            <x-button.link x-show="!area" class="ml-2 text-blue-600" @click="area=true"> Listar área
                                de
                                conocimiento </x-button.link>
                            <x-button.link x-show="area" class="ml-2 text-blue-600" @click="area=false">Ocultar
                                Lista
                            </x-button.link>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <div class="space-y-3">
                            <div class="grid grid-cols-6 gap-6">
                                {{-- areasKnowledge --}}
                                <x-input.group label="Para actividad libre" for="actividad_libre"
                                    clases="col-span-6 sm:col-span-6">
                                    <x-input.checkbox wire:model.defer="actividad_libre" name="actividad_libre"
                                        id="actividad_libre" value="{{ $actividad_libre = !$actividad_libre }}" />

                                </x-input.group>
                            </div>
                            <div class="grid grid-cols-6 gap-6">

                                {{-- areasKnowledge --}}
                                <x-input.group label="Nombre de  Área de Conocimiento" for="nameArea"
                                    clases="col-span-6 sm:col-span-6" :error="$errors->first('areaKnowledge.name')">
                                    <x-input.text type="text" wire:model.defer="areaKnowledge.name" id="nameArea" />
                                </x-input.group>
                                <x-input.group label="Total de Crédito" for="TotalCreditsArea"
                                    clases="col-span-6 sm:col-span-6"
                                    :error="$errors->first('areaKnowledge.total_credits')">
                                    <x-input.text type="text" wire:model.defer="areaKnowledge.total_credits"
                                        id="TotalCreditsArea" />
                                </x-input.group>
                            </div>
                            <div x-show="area">
                                <x-table>
                                    <x-slot name="head">
                                        <x-table.heading class="whitespace-nowrap" scope="col">Nombre
                                        </x-table.heading>
                                        <x-table.heading>opciónes</x-table.heading>
                                    </x-slot>
                                    <x-slot name="body">
                                        @forelse ($selectAreas as $area)
                                        <x-table.row wire:loading.class.delay="opacity-50">
                                            <x-table.cell class="whitespace-nowrap text-left">
                                                {{ mb_strtoupper($area->name) }}
                                            </x-table.cell>
                                            <x-table.cell>
                                                <div class=" text-center">
                                                    <x-button.danger-icon
                                                        wire:click.defer="deleteArea({{ $area->id }})">
                                                        <x-icon.trash text="red"></x-icon.trash>
                                                    </x-button.danger-icon>
                                                </div>
                                            </x-table.cell>
                                        </x-table.row>
                                        @empty
                                        <x-table.row>
                                            <x-table.cell colspan="4">
                                                <div class="flex justify-center items-center">
                                                    <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                                    <span class="font-medium py-8 text-neutral-500 text-xl">
                                                        datos no encontrados...
                                                    </span>
                                                </div>
                                            </x-table.cell>
                                        </x-table.row>
                                        @endforelse
                                    </x-slot>
                                </x-table>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <x-button.danger wire:click="$set('showEditModal', false)">Cancelar</x-button.danger>
                        <x-button.success wire:click.prevent="save">Guardar</x-button.success>
                    </x-slot>
                </x-modal.dialog>
            </form>
            <!--Edit And Create Course Modal-->
            <div>
                <form>
                    <x-modal.dialog wire:model.defer="showEditModalCourse">
                        <x-slot name="title">Curso</x-slot>
                        <x-slot name="content">
                            <div class="grid grid-cols-6 gap-6">
                                <x-input.group for="area_knowledge_id" label="" clases="col-span-6 sm:col-span-6"
                                    :error="$errors->first('course.area_knowledge_id')">
                                    <x-input.select wire:model.defer="course.area_knowledge_id" id="area_knowledge_id">
                                        <option value="" selected>seleccione Área de conocimiento</option>
                                        @foreach ($selectAreas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}
                                        </option>
                                        @endforeach
                                    </x-input.select>
                                </x-input.group>
                                <x-input.group for="nameCourse" label="Nombre" clases="col-span-6 sm:col-span-4"
                                    :error="$errors->first('course.name')">
                                    <x-input.text type="text" wire:model.defer="course.name" id="nameCourse" />
                                </x-input.group>
                                <x-input.group for="code" label="Código" clases="col-span-6 sm:col-span-2"
                                    :error="$errors->first('course.code')">
                                    <x-input.text type="text" wire:model.defer="course.code" id="code" />
                                </x-input.group>
                                <x-input.group for="theoretic_hour" label="Horas Teóricas"
                                    clases="col-span-6 sm:col-span-2" :error="$errors->first('course.theoretic_hour')">
                                    <x-input.text type="text" wire:model.defer="course.theoretic_hour"
                                        id="theoretic_hour" />
                                </x-input.group>
                                <x-input.group for="practical_hour" label="Horas Prácticas"
                                    clases="col-span-6 sm:col-span-2" :error="$errors->first('course.practical_hour')">
                                    <x-input.text type="text" wire:model.defer="course.practical_hour"
                                        id="practical_hour" />
                                </x-input.group>
                                <x-input.group for="type_course" label="" clases="col-span-6 sm:col-span-3"
                                    :error="$errors->first('course.type_course')">
                                    <x-input.select wire:model.defer="course.type_course" id="type_course">
                                        <option value="" selected>Seleccione Tipo de Curso</option>
                                        @foreach (App\Models\Course::TYPECOURSE as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </x-input.select>
                                </x-input.group>
                                <x-input.group for="university_law" label="" clases="col-span-6 sm:col-span-3"
                                    :error="$errors->first('course.university_law')">
                                    <x-input.select wire:model.defer="course.university_law" id="university_law">
                                        <option value="" selected>Seleccione Ley Universitaria</option>
                                        @foreach (App\Models\Course::UNIVERSITYLAW as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </x-input.select>
                                </x-input.group>
                                <x-input.group for="prerequisite" label="Pre Requisito: Ejm 160"
                                    clases="col-span-6 sm:col-span-2" :error="$errors->first('course.prerequisite')">
                                    <x-input.text type="text" wire:model.defer="course.prerequisite"
                                        id="prerequisite" />
                                </x-input.group>
                                <x-input.group for="credits" label="Créditos" clases="col-span-6 sm:col-span-2"
                                    :error="$errors->first('course.credits')">
                                    <x-input.text type="text" wire:model.defer="course.credits" id="credits" />
                                </x-input.group>
                                <x-input.group for="cycle" label="Semestre" clases="col-span-6 sm:col-span-2"
                                    :error="$errors->first('course.cycle')">
                                    <x-input.select wire:model.defer="course.cycle" id="cycle">
                                        <option value="" selected>Seleccione</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </x-input.select>
                                </x-input.group>
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <x-button.danger wire:click="$set('showEditModalCourse', false)">Cancelar</x-button.danger>
                            <x-button.success wire:click.prevent="saveCourse">Guardar</x-button.success>
                        </x-slot>
                    </x-modal.dialog>
                </form>
            </div>

            <!--Assign Course to  Area Modal-->
            <div>
                <form>
                    <x-modal.dialog maxWidth="4xl" wire:model.defer="showModalAssignCourseArea">
                        <x-slot name="title">Asignar Curso a Área</x-slot>
                        <x-slot name="content">
                            <div class="space-y-4">
                                <div class=" flex w-full  space-x-4">
                                    <x-input.text wire:model.defer="searchCourse" addClass="w-1/2" name="search"
                                        placeholder="Buscar" type="search" wire:keydown.enter.prevent="loadCourses" />

                                </div>
                                <div>
                                    <x-input.group for="area_knowledge_id" label="" clases="col-span-6 sm:col-span-6"
                                        :error="$errors->first('course.area_knowledge_id')">
                                        <x-input.select wire:model.defer="areaKnowledge_id" id="area_knowledge_id">
                                            <option value="" selected>seleccione Área de conocimiento</option>
                                            @foreach ($selectAreas as $area)
                                            <option value="{{ $area->id }}">{{ $area->name }}
                                            </option>
                                            @endforeach
                                        </x-input.select>
                                    </x-input.group>
                                </div>
                                <div>
                                    @if (!empty($selectCourseToAddArea))
                                    <div>
                                        <div class="mt-6 flow-root">
                                            <ul role="list" class="-my-5 divide-y divide-gray-200">
                                                @foreach ($selectCourseToAddArea as $courseAdd)
                                                <li class="py-4">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="min-w-0 flex-1">
                                                            <p class="truncate text-sm font-medium text-gray-900">
                                                                @if (is_array($courseAdd))
                                                                {{ $courseAdd['name'] }}
                                                                @else
                                                                {{ $courseAdd->name }}
                                                                @endif
                                                            </p>
                                                            <p class="truncate text-sm text-gray-500">
                                                                @if (is_array($courseAdd))
                                                                {{ $courseAdd['code'] }}
                                                                @else
                                                                {{ $courseAdd->code }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <a href="#"
                                                                wire:click.prevent="removeCourseToAreaAssign({{ $courseAdd['id'] }})"
                                                                class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">Quitar</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <x-table>
                                        <x-slot name="head">
                                            <x-table.heading class="whitespace-nowrap" scope="col">Código
                                            </x-table.heading>
                                            <x-table.heading class="whitespace-nowrap" scope="col">Nombre
                                            </x-table.heading>
                                        </x-slot>
                                        <x-slot name="body">
                                            @forelse ($assignCourses as $course)
                                            <x-table.row wire:key="{{ $course->id }}"
                                                wire:loading.class.delay="opacity-50" class="cursor-pointer"
                                                wire:click.prenvent="addCourseToArea({{ $course }})">
                                                <x-table.cell class="whitespace-nowrap text-left">
                                                    {{ mb_strtoupper($course->code) }}
                                                </x-table.cell>
                                                <x-table.cell class="whitespace-nowrap text-left">
                                                    {{ mb_strtoupper($course->name) }}
                                                </x-table.cell>

                                            </x-table.row>
                                            @empty
                                            <x-table.row>
                                                <x-table.cell colspan="4">
                                                    <div class="flex justify-center items-center">
                                                        <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                                        <span class="font-medium py-8 text-neutral-500 text-xl">
                                                            datos no encontrados...
                                                        </span>
                                                    </div>
                                                </x-table.cell>
                                            </x-table.row>
                                            @endforelse
                                        </x-slot>
                                    </x-table>
                                </div>
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <x-button.danger wire:click="$set('showModalAssignCourseArea', false)">Cancelar
                            </x-button.danger>
                            <x-button.success wire:click.prevent="saveAssignCourseArea">Guardar</x-button.success>
                        </x-slot>
                    </x-modal.dialog>
                </form>
            </div>

            <!--Confirm Delete Area and course  Modal-->
            <div>
                <form>
                    <x-modal.confirmation wire:model.defer="showDeleteModal">
                        <div class="grid grid-cols-6 gap-6">
                            <x-slot name="title">Eliminar Registro </x-slot>
                            <x-slot name="content">
                                ¿Estas seguro de eliminar este registro? Esta acción es irreversible
                            </x-slot>
                            <x-slot name="footer">
                                <x-button.secondary wire:click.prevent="$set('showDeleteModal', false)">Cancelar
                                </x-button.secondary>
                                <x-button.danger wire:click.prevent="deleteSelected">Eliminar</x-button.danger>
                            </x-slot>
                        </div>
                    </x-modal.confirmation>

                </form>
            </div>

            <!--pre requisito-->
            <div x-data="{ showAdd: false }">
                {{-- <x-button.success-icon wire:click="$toggle('showModal')" class="flex items-center space-x-2">
                    <x-icon.list-bullet class="text-green-600" />
                </x-button.success-icon> --}}

                <form wire:submit.prevent="savePre">
                    <x-modal.dialog wire:model.defer="showModalPre">
                        <x-slot name="title">
                            <div class="space-y-4">
                                <div class="flex space-x-6">
                                    <h1 class="text-gray-900 font-bold">Curso: </h1>
                                    <span
                                        class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800">
                                        {{ mb_strtoupper($coursePre->name ?? 'no') }}
                                    </span>

                                </div>

                                <div class="flex space-x-6">
                                    <p class="text-gray-900  font-bold"> Código:</p> <span
                                        class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800">
                                        {{ mb_strtoupper($coursePre->code ?? 'no') }}
                                    </span>
                                </div>

                                @if ($curriculaState->state == 1)
                                <div class="flex">
                                    <x-button.success x-cloak x-show="!showAdd" @click="showAdd=!showAdd">
                                        <x-icon.plus>

                                        </x-icon.plus>
                                        Agregar
                                    </x-button.success>
                                    <x-button.secondary x-cloak x-show="showAdd" @click="showAdd=!showAdd">
                                        <x-icon.minus-circle>

                                        </x-icon.minus-circle>
                                        Ocultar
                                    </x-button.secondary>
                                </div>
                                @endif

                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <div class="space-y-6">
                                <div x-xloak x-show="showAdd">
                                    @if ($coursesPre)


                                    <x-input.select wire:model.defer="add_course_id" name="selectCourse"
                                        wire:change="handleChange($event.target.value)">
                                        <option value="" selected>selecione Curso</option>
                                        @foreach ($coursesPre as $courseList)
                                        <option value="{{ $courseList->id }}">{{ $courseList->code }} --
                                            {{ $courseList->name }}</option>
                                        @endforeach
                                    </x-input.select>
                                    @endif
                                </div>
                                @if ($errors->any())
                                <div>
                                    <div class="rounded-md bg-red-50 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <!-- Heroicon name: mini/x-circle -->
                                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <div class="flex">
                                                    <h3 class="text-sm font-medium text-red-800">Hay
                                                        {{ $errors->count() }}
                                                        {{ $errors->count() > 1 ? 'errores' : 'error' }} </h3>
                                                </div>
                                                <div class="mt-2 text-sm text-red-700">
                                                    <ul role="list" class="list-disc space-y-1 pl-5">
                                                        @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if ($selectCourses)
                                <div>
                                    <ul role="list" class="divide-y divide-gray-200">
                                        @if ($coursesPre)

                                        @foreach ($coursesPre->whereIn('id', $selectCourses) as $courseAdd)
                                        <li class="flex justify-between items-center py-2 pl-2  pr-2">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $courseAdd->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $courseAdd->code }}
                                                </p>
                                            </div>
                                            <div>
                                                <x-icon.trash class="text-red-800 pointer hover:text-red-500"
                                                    wire:click.prevent="removeSelectCourse({{ $courseAdd->id }})">

                                                </x-icon.trash>
                                            </div>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                                @endif
                                <div class="overflow-x-auto">
                                    <x-table class="min-w-full table-auto " overX="overflow-x-auto scrollbar-thin">
                                        <x-slot name="head">
                                            <x-table.heading class="whitespace-nowrap" scope="col">Prerrequisito
                                            </x-table.heading>
                                            <x-table.heading class="whitespace-nowrap" scope="col">Código
                                            </x-table.heading>
                                            @if ($curriculaState->state == 1)
                                            <x-table.heading>opciónes</x-table.heading>
                                            @endif
                                        </x-slot>
                                        <x-slot name="body" class="min-w-full">
                                            @if (optional($coursePre)->prerequisites)
                                            @forelse ($coursePre->prerequisites as $course)
                                            <x-table.row class="cursor-pointer" wire:loading.class.delay="opacity-50"
                                                wire:key="course-{{ $course->id }}">
                                                <x-table.cell class="whitespace-nowrap text-left">
                                                    {{ mb_strtoupper($course->name) }}</x-table.cell>
                                                <x-table.cell class="whitespace-nowrap text-left">
                                                    {{ mb_strtoupper($course->code) }}</x-table.cell>
                                                @if ($curriculaState->state == 1)
                                                <x-table.cell class="pl-9">
                                                    <div class="space-x-2 ">
                                                        <x-button.danger-icon
                                                            wire:click.prevent="deletePrerequisite({{ $course->id }})">
                                                            <x-icon.trash text="yellow"></x-icon.trash>
                                                        </x-button.danger-icon>
                                                    </div>
                                </div>
                                </x-table.cell>
                                @endif
                                </x-table.row>
                                @empty
                                <x-table.row>
                                    <x-table.cell colspan="4">
                                        <div class="flex justify-center items-center">
                                            <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                            <span class="font-medium py-8 text-neutral-500 text-xl">
                                                datos no encontrados...
                                            </span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endforelse
                                @else
                                <x-table.row>
                                    <x-table.cell colspan="4">
                                        <div class="flex justify-center items-center">
                                            <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                            <span class="font-medium py-8 text-neutral-500 text-xl">
                                                datos no encontrados...
                                            </span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endif
                        </x-slot>
                        </x-table>
            </div>
        </div>
        </x-slot>

        <x-slot name="footer">
            <x-button.secondary wire:click="cancelFormPre" @click="showAdd=false">Cancel
            </x-button.secondary>
            @if ($curriculaState->state == 1 && $selectCourses)
            <x-button.success type="submit">Agregar</x-button.success>
            @endif
        </x-slot>
        </x-modal.dialog>
        </form>
</div>

<!--pre detail course-->
<div>


    <form >
        <x-modal.dialog wire:model.defer="showModalDetailCourse">
            <x-slot name="title">

            </x-slot>
            <x-slot name="content">

                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Detalle del curso</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Datos completo del curso.</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ mb_strtoupper($detailCourse->name ?? 'no') }}

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Código </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ mb_strtoupper($detailCourse->code ?? 'no') }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Unidades de Aprendizaje</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex w-0 flex-1 items-center">


                                                <span class="ml-2 w-0 flex-1 truncate">Créditos </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                {{ mb_strtoupper($detailCourse->credits ?? 'no asignado') }}
                                            </div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex w-0 flex-1 items-center">


                                                <span class="ml-2 w-0 flex-1 truncate">Horas Prácticas </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                {{ mb_strtoupper($detailCourse->practical_hour ?? 'no asignado') }}
                                            </div>
                                        </li>

                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex w-0 flex-1 items-center">


                                                <span class="ml-2 w-0 flex-1 truncate">Horas Teórica </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                {{ mb_strtoupper($detailCourse->theoretic_hour ?? 'no asignado') }}
                                            </div>
                                        </li>


                                    </ul>

                                </dd>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Tipo de Curso</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailCourse)
                                    {{ mb_strtoupper(
                                    App\Models\Course::TYPECOURSE[$detailCourse->type_course] ??
                                    'no
                                    asignado',
                                    ) }}
                                    @else
                                    No tiene información disponible
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Ley Universitaria</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailCourse)
                                    {{ mb_strtoupper(
                                    App\Models\Course::UNIVERSITYLAW[$detailCourse->university_law] ??
                                    'no
                                    asignado',
                                    ) }}
                                    @else
                                    No tiene información disponible
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Ciclo</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ mb_strtoupper($detailCourse->cycle ?? 'no asignado') }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Requisitos</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailCourse)
                                    @if ($detailCourse->prerequisite)
                                    {{ '+' . $detailCourse->prerequisite . ' CRÉD' }}
                                    ,<br>
                                    @endif
                                    @if (empty($detailCourse->prerequisite) && $detailCourse->prerequisites->count() ==
                                    0)
                                    -
                                    @endif
                                    @if ($detailCourse->prerequisites->count() > 0)
                                    @foreach ($detailCourse->prerequisites as $prerequsite)
                                    {{ mb_strtoupper($prerequsite->code) }}
                                    @if (!$loop->last)
                                    ,<br>
                                    @endif
                                    @endforeach

                                    @endif
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Área de conocimiento</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailCourse)
                                    {{ mb_strtoupper($detailCourse->areaKnowledges->name) }}
                                    @endif
                                </dd>
                            </div>

                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Curricula</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    @if ($detailCourse)

                                    @if ($detailCourse->curriculas)
                                    {{ mb_strtoupper($detailCourse->curriculas->name) }}
                                    @else
                                    No asignado
                                    @endif

                                    @endif

                                </dd>
                            </div>


                        </dl>
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="cancelFormPre">Cancelar
                </x-button.secondary>

            </x-slot>
        </x-modal.dialog>
    </form>
</div>

</div>
</main>
</div>