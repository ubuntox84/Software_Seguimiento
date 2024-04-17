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
                        <x-input.text wire:model="filters.search" name="search"
                            class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
                            placeholder="buscar otro" type="search" />
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
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Curricula</h1>
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
                            <x-button.link wire:click.prevent="toggleShowFilters">@if($showFilters) Ocultar @endIf
                                Buscqueda avanzada...</x-button.link>
                        </div>
                        <div>
                            <x-input.group borderless paddingless for="perPage1" label="">
                                <x-input.select wire:model="perPage" id="perPage1">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
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
                                    <x-icon.download class="text-gray-400" /> <span>Exportar</span>
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
                    <div class="flex justify-between  ">
                        <div class=" flex w-full lg:w-2/4 md:w-2/4 space-x-4">
                            <x-input.text wire:model="filters.search" placeholder="Buscar curricula" type="search"
                                name="searchMobile" />
                            <x-button.link class="text-blue-600 focus:text-blue-800"
                                wire:click.prevent="toggleShowFilters">@if($showFilters) Ocultar @endIf
                                Búsqueda avanzada...</x-button.link>
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
                                <x-dropdown.item type="button" wire:click="exportSelected"
                                    class="flex items-center space-x-2">
                                    <x-icon.download class="text-blue-600" /> <span>Exportar</span>
                                </x-dropdown.item>
                                <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')"
                                    class="flex items-center space-x-2">
                                    <x-icon.trash class="text-red-500" /> <span>Eliminar</span>
                                </x-dropdown.item>
                            </x-dropdown>
                            <livewire:import-curriculas>
                                <x-button.success wire:click="create">
                                    <x-icon.plus /> Nuevo
                                </x-button.success>
                        </div>
                    </div>

                </div>
                <!--busqueda avanzada-->
                <div class="mx-4 md:mx-0">
                    @if ($showFilters)
                    <div class="bg-gray-200 p-4 rounded mt-6 shadow-inner flex relative">
                        <div class="w-1/2 pr-2 space-y-4">

                            <x-input.checkbox forIn="state" wire:model.lazy="filters.state">
                                {{ $filters['state']==true?'Activo':'Inactivo' }}
                            </x-input.checkbox>

                            <x-input.group for="filter-date-min" label="Fecha mínima de aprobación ">
                                <x-input.text wire:model.lazy="filters.date-min" type="date" id="filter-date-min"/>
                            </x-input.group>

                            <x-input.group for="filter-date-max" label="Fecha máxima de aprobación">
                                <x-input.text wire:model.lazy="filters.date-max" id="filter-date-max" type="date" />
                            </x-input.group>
                        </div>
                        <div class="w-1/2 pl-2 space-y-4">


                            <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reiniciar
                                filtros</x-button.link>
                        </div>

                        {{-- <div class="w-1/2 pl-2 space-y-4">
                            <x-input.group inline for="filter-date-min" label="Minimum Date">
                                <x-input.date wire:model="filters.date-min" id="filter-date-min"
                                    placeholder="MM/DD/YYYY" />
                            </x-input.group>

                            <x-input.group inline for="filter-date-max" label="Maximum Date">
                                <x-input.date wire:model="filters.date-max" id="filter-date-max"
                                    placeholder="MM/DD/YYYY" />
                            </x-input.group>

                            <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset
                                Filters</x-button.link>
                        </div> --}}
                    </div>
                    @endif
                </div>
                <!--Curricula Table-->
                <div class="-my-2 mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    {{-- @json($curriculas) --}}
                    <div class="space-y-4 inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <x-table>
                            <x-slot name="head">
                                <x-table.heading scope="col">
                                    <x-input.checkbox wire:model="selectPage" name="selectPage">

                                    </x-input.checkbox>
                                </x-table.heading>
                                <x-table.heading class="whitespace-nowrap" scope="col" sortable multi-column
                                    wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">Nombre
                                </x-table.heading>
                               
                                <x-table.heading> Estado</x-table.heading>
                                <x-table.heading> Opciones</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @if ($selectPage)
                                <x-table.row wire:key="row-message">
                                    <x-table.cell class="bg-gray-200" colspan="9">
                                        @unless ($selectAll)
                                        <div>
                                            <span> Selecccionaste eliminar <strong> {{ $curriculas->count() }} </strong>
                                                curriculas, ¿ desea selecionar todas las <strong>{{ $curriculas->total()
                                                    }}</strong>? </span>
                                            <x-button.link wire:click.prevent="selectAll" class="ml-2 text-blue-600">
                                                Seleccionar todo</x-button.link>
                                        </div>
                                        @else
                                        <span> Actuallmente selecccionaste todas las <strong>{{ $curriculas->total()
                                                }}</strong> curriculas.</span>
                                        @endif
                                    </x-table.cell>
                                </x-table.row>
                                @endif
                                @forelse ($curriculas as $curricula)
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{$curricula->id  }}">

                                    <x-table.cell>
                                        <x-input.checkbox wire:model="selected" value="{{$curricula->id}}"
                                            name="selected" />
                                    </x-table.cell>
                                    <x-table.cell class="whitespace-nowrap">{{ $curricula->name }}</x-table.cell>
                                  
                                    <x-table.cell class="whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $curricula->state_colors }}-100 text-{{ $curricula->state_colors }}-800 capitalize">
                                            {{ $curricula->state==0?'No Vigente':'Vigente' }}
                                        </span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class=" text-center">
                                            <x-button.warning-icon wire:click.defer="edit({{ $curricula->id }})">
                                                <x-icon.edit></x-icon.edit>
                                            </x-button.warning-icon>
                                            <button class=" text-blue-700  hover:bg-blue-200 active:bg-blue-700"
                                                    wire:click.defer="showDetailCurricula({{ $curricula->id }})">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </button>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @empty
                                <x-table.row>
                                    <x-table.cell colspan="9">
                                        <div class="flex justify-center items-center">
                                            <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                            <span class="font-medium py-8 text-neutral-500 text-xl">
                                                Curriculas no encontradas...
                                            </span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table>
                        {{ $curriculas->links() }}
                    </div>
                </div>
            </div>

            <!--Edit And Create Curricula Modal-->
            <form>
                <x-modal.dialog maxWidth="4xl" wire:model="showEditModal">

                    <x-slot name="title">Currícula
                        <x-button.link class="text-blue-600 focus:text-blue-800" wire:click.prevent="toggleShowApi">
                            @if ($apiShow)
                            regresar ...
                            @else
                            agregar desde API...
                            @endif
                        </x-button.link>

                    </x-slot>


                    <x-slot name="content">
                        @if (!$apiShow)
                        <div class="grid grid-cols-6 gap-6">

                            <x-input.group label="Nombre" for="editing.name" clases="col-span-6 sm:col-span-6"
                                :error="$errors->first('editing.name')">
                                <x-input.text wire:model.lazy="editing.name" id="editing.name" type="text" />
                            </x-input.group>

                            <x-input.group label="Código" for="code" clases="col-span-6 sm:col-span-2"
                                :error="$errors->first('editing.code')">
                                <x-input.text wire:model.lazy="editing.code" id="code" type="text" />
                            </x-input.group>

                            <x-input.group label="Escuela Profesional" for="profesional_school"
                                clases="col-span-6 sm:col-span-4" :error="$errors->first('editing.profesional_school')">
                                <x-input.text wire:model.lazy="editing.profesional_school" id="profesional_school"
                                    type="text" />
                            </x-input.group>

                            <x-input.group label="Fecha Inicio" for="date_approved" clases="col-span-6 sm:col-span-2"
                                :error="$errors->first('editing.date_approved')">
                                <x-input.date wire:model.lazy="editing.date_approved" id="date_approved"
                                    placeholder="AAAA-MM-DD" />
                            </x-input.group>

                            <x-input.group label="Resolución" for="resolution" clases="col-span-6 sm:col-span-4"
                                :error="$errors->first('editing.resolution')">
                                <x-input.text wire:model.lazy="editing.resolution" id="resolution" type="text" />
                            </x-input.group>

                            <x-input.group label="Fecha Activa" for="date_active" clases="col-span-6 sm:col-span-2"
                                :error="$errors->first('editing.date_active')">
                                <x-input.date wire:model.lazy="editing.date_active" id="date_active"
                                    placeholder="AAAA-MM-DD" />
                            </x-input.group>

                            <x-input.group label="Fecha Inactivo" for="date_inactive" clases="col-span-6 sm:col-span-4"
                                :error="$errors->first('editing.date_inactive')">
                                <x-input.date wire:model.lazy="editing.date_inactive" id="date_inactive"
                                    placeholder="AAAA-MM-DD" />
                            </x-input.group>

                            <x-input.group label="Cred. Obligatorios" for="compulsory" clases="col-span-6 sm:col-span-2"
                                :error="$errors->first('editing.compulsory')">
                                <x-input.text wire:model.lazy="editing.compulsory" id="compulsory" type="text" />
                            </x-input.group>

                            <x-input.group label="Cred. Electivos" for="elective" clases="col-span-6 sm:col-span-2"
                                :error="$errors->first('editing.elective')">
                                <x-input.text wire:model.lazy="editing.elective" id="elective" type="text" />
                            </x-input.group>

                            <x-input.group label="Cred. Actividades Libres" for="free_activity"
                                clases="col-span-6 sm:col-span-2" :error="$errors->first('editing.free_activity')">
                                <x-input.text wire:model.lazy="editing.free_activity" id="free_activity" type="text" />
                            </x-input.group>

                            <x-input.group label="Cred. Prácticas Pre Profesionales" for="pre_professional_practice"
                                clases="col-span-6 sm:col-span-3"
                                :error="$errors->first('editing.pre_professional_practice')">
                                <x-input.text wire:model.lazy="editing.pre_professional_practice"
                                    id="pre_professional_practice" type="text" />
                            </x-input.group>

                            <x-input.group label="Semestre Inicio" for="semester_start"
                                clases="col-span-6 sm:col-span-3" :error="$errors->first('editing.semester_start')">
                                <x-input.text wire:model.lazy="editing.semester_start" id="semester_start"
                                    type="text" />
                            </x-input.group>



                        </div>
                        @else
                        <div >
                            <x-table class="table-auto min-w-full  ">
                                <x-slot name="head">
                                    <x-table.heading class="" scope="col">Plan de Estudios</x-table.heading>
                                    <x-table.heading class="" scope="col">Estado </x-table.heading>
                                    <x-table.heading class="" scope="col">Total </x-table.heading>
                                    <x-table.heading scope="col">opciónes</x-table.heading>
                                </x-slot>
                                <x-slot name="body">
                                    @if (!is_null($listCurriculas) && isset($listCurriculas['list']))
                                        
                                   
                                    @forelse ($listCurriculas['list'] as $curricula)
                                    <x-table.row wire:loading.class.delay="opacity-50">
                                        <x-table.cell class="whitespace-nowrap text-left text-xs">{{ mb_strtoupper(
                                            $curricula['plan'] )
                                            }}
                                        </x-table.cell>
                                       
                                        <x-table.cell class="whitespace-nowrap text-left text-xs">{{ mb_strtoupper(
                                            $curricula['status'] )
                                            }}
                                        </x-table.cell>
                                        <x-table.cell class="whitespace-nowrap text-left text-xs">{{ mb_strtoupper(
                                            $curricula['credits'] )
                                            }}
                                        </x-table.cell>
                                        <x-table.cell class="whitespace-nowrap text-left text-xs">
                                            
                                                <x-button.success wire:click.defer="saveCurriculaApi({{json_encode($curricula)}})">
                                                   Agregar
                                                </x-button.success>
                                           
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
                        @endif


                    </x-slot>

                    <x-slot name="footer">
                        @if (!$apiShow)
                        <x-button.danger wire:click="$set('showEditModal', false)">Cancelar</x-button.danger>
                        <x-button.success wire:click.prevent="save">Guardar</x-button.success>

                        @endif

                    </x-slot>

                </x-modal.dialog>
            </form>
            <!--Confirm Delete Curricula Modal-->
            <form>
                <x-modal.confirmation wire:model.defer="showDeleteModal">
                    <div class="grid grid-cols-6 gap-6">
                        <x-slot name="title">Eliminar Currícula </x-slot>
                        <x-slot name="content">
                            ¿Estas seguro de eliminar esta curricula? Esta acción es irreversible
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
                    <!--detail user-->
<div>


    <form >
        <x-modal.dialog wire:model.defer="showModalDetailCurricula">
            <x-slot name="title">

            </x-slot>
            <x-slot name="content">

                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Detalle del Usuario</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Datos completo del usuario.</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                         
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ mb_strtoupper($detailCurricula->name ?? 'no') }}

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Código </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ mb_strtoupper($detailCurricula->code ?? 'no') }}
                                </dd>
                            </div>
                           
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Facultad</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailCurricula)
                                    {{ mb_strtoupper($detailCurricula->faculties->name??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                  @if ($detailCurricula)
                                    {{ mb_strtoupper($detailCurricula->departments->name??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif
                                </dd>
                            </div>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Creditos Obligatorio</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailCurricula)
                                    {{ mb_strtoupper($detailCurricula->compulsory??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Creditos electivos</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                  @if ($detailCurricula)
                                    {{ mb_strtoupper($detailCurricula->elective??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif
                                </dd>
                            </div>
                             </div>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Creditos Actividad Libre</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailCurricula)
                                    {{ mb_strtoupper($detailCurricula->free_activity??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Creditos Practicas Profesional</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                  @if ($detailCurricula)
                                    {{ mb_strtoupper($detailCurricula->pre_professional_practice??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif
                                </dd>
                            </div>
                           
                           
                             <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailCurricula)
                                    <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $detailCurricula->state_colors }}-100 text-{{ $detailCurricula->state_colors }}-800 capitalize">
                                            {{ $detailCurricula->state==0?'No Vigente':'Vigente' }} 
                                    </span>
                                    @else
                                    No tiene información disponible
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Fecha de aprobacion</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                  @if ($detailCurricula)
                                    {{ mb_strtoupper(\Carbon\Carbon::parse($detailCurricula->date_active)->format('d-m-Y') ??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif
                                </dd>
                            </div>
                             <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Fecha Inactivo</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                  @if ($detailCurricula)
                                    {{ mb_strtoupper(\Carbon\Carbon::parse($detailCurricula->date_inactive)->format('d-m-Y') ??'no asignado',) }}
                                    @else
                                    No tiene información disponible
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
        {{--
        <x-notification-success /> --}}
    </main>

</div>