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
                            placeholder="buscar" type="search" name="search_mobile" />
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
                <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate"></h1>
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
                            <x-input.text wire:model="filters.search" placeholder="Buscar" type="search"
                                name="search_faculty" />
                            <x-button.link class="text-blue-600 focus:text-blue-800"
                                wire:click.prevent="toggleShowFilters">
                                @if ($showFilters) Ocultar @endIf
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

                        </div>
                    </div>

                </div>
                <!--busqueda avanzada-->
                <div class="mx-4 md:mx-0">
                    @if ($showFilters)
                        <div class="bg-gray-200 p-4 rounded mt-6 shadow-inner flex relative">
                            <div class="w-1/2 pr-2 space-y-4">



                                <x-input.group for="filter-date-min" label="Fecha mínima">
                                    <x-input.text wire:model.lazy="filters.date-min" type="date" />
                                </x-input.group>

                                <x-input.group for="filter-date-max" label="Fecha máxima">
                                    <x-input.text wire:model.lazy="filters.date-max" id="filter-date-max"
                                        type="date" />
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
                    {{-- @json($selected) --}}
                    <div class="space-y-4 inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <x-table>
                            <x-slot name="head">
                                <x-table.heading scope="col">
                                    <x-input.checkbox wire:model="selectPage" name="selectPage">

                                    </x-input.checkbox>
                                </x-table.heading>
                                <x-table.heading class="whitespace-nowrap" scope="col" sortable multi-column
                                    wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">Nombres
                                </x-table.heading>
                                <x-table.heading class="whitespace-nowrap" scope="col" sortable multi-column
                                    wire:click="sortBy('name')" :direction="$sorts['code'] ?? null">Código
                                </x-table.heading>
                              
                                <x-table.heading class="whitespace-nowrap" scope="col">Rol
                                </x-table.heading>
                                <x-table.heading> Opciones</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @if ($selectPage)
                                    <x-table.row wire:key="row-message">
                                        <x-table.cell class="bg-gray-200" colspan="8">
                                            @unless ($selectAll)
                                                <div>
                                                    <span> Selecccionaste eliminar <strong> {{ $users->count() }} </strong>
                                                        Usuarios, ¿ desea selecionar todas las
                                                        <strong>{{ $users->total() }}</strong>? </span>
                                                    <x-button.link wire:click.prevent="selectAll"
                                                        class="ml-2 text-blue-600">
                                                        Seleccionar todo</x-button.link>
                                                </div>
                                            @else
                                                <span> Actuallmente selecccionaste todas las
                                                    <strong>{{ $users->total() }}</strong> Usuarios.</span>
                                    @endif
                                    </x-table.cell>
                                    </x-table.row>
                                    @endif
                                    @forelse ($users as $user)
                                        <x-table.row wire:loading.class.delay="opacity-50"
                                            wire:key="row-{{ $user->id }}">

                                            <x-table.cell>
                                                <x-input.checkbox wire:model="selected" value="{{ $user->id }}"
                                                    name="selected" />
                                            </x-table.cell>
                                            <x-table.cell class="whitespace-nowrap">{{ mb_strtoupper($user->name) }}
                                                {{ mb_strtoupper($user->surname) }}
                                            </x-table.cell>
                                           
                                            <x-table.cell class="whitespace-nowrap">{{ mb_strtoupper($user->code) }}
                                            </x-table.cell>
                                           
                                            <x-table.cell class="whitespace-nowrap">

                                                @foreach ($user->roles as $role)
                                                    @switch($role->name)
                                                        @case('admin')
                                                            {{ mb_strtoupper('Administrador') }} @if (!$loop->last)
                                                                , <br>
                                                            @endif
                                                        @break

                                                        @case('commission')
                                                            {{ mb_strtoupper('Comisión') }} @if (!$loop->last)
                                                                , <br>
                                                            @endif
                                                        @break

                                                        @case('user')
                                                            {{ mb_strtoupper('usuario') }} @if (!$loop->last)
                                                                , <br>
                                                            @endif
                                                        @break

                                                        @default
                                                            {{ $user->role }}
                                                    @endswitch
                                                @endforeach
                                            </x-table.cell>

                                            <x-table.cell>
                                                <div class=" text-center">
                                                    <x-button.warning-icon wire:click.defer="edit({{ $user->id }})">
                                                        <x-icon.edit></x-icon.edit>
                                                    </x-button.warning-icon>
                                                     <button class=" text-blue-700  hover:bg-blue-200 active:bg-blue-700"
                                                    wire:click.defer="showDetailUser({{ $user->id }})">
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
                                                <x-table.cell colspan="8">
                                                    <div class="flex justify-center items-center">
                                                        <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                                        <span class="font-medium py-8 text-neutral-500 text-xl">
                                                            Usuarios no encontradas...
                                                        </span>
                                                    </div>
                                                </x-table.cell>
                                            </x-table.row>
                                        @endforelse
                                    </x-slot>
                                </x-table>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>

                    <!--Edit And Create User Modal-->
                    <form>
                        <x-modal.dialog wire:model="showEditModal" maxWidth="4xl">

                            <x-slot name="title">Editar Usuario </x-slot>

                            <x-slot name="content">

                                <div class="grid grid-cols-6 gap-6">
                                    <!-- Code -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <x-jet-label for="editing.code" value="{{ __('Code') }}" />
                                        <x-jet-input id="editing.code" type="text" class="mt-1 block w-full"
                                            wire:model.defer="editing.code" placeholder="0020100438"
                                            autocomplete="editing.code" />
                                        <x-jet-input-error for="editing.code" class="mt-2" />
                                    </div>
                                    <!-- Name -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="editing.name" value="{{ __('Nombres') }}" />
                                        <x-jet-input id="editing.name" type="text" class="mt-1 block w-full"
                                            wire:model.defer="editing.name" autocomplete="editing.name" />
                                        <x-jet-input-error for="editing.name" class="mt-2" />
                                    </div>
                                    <!-- LastName -->
                                    <div class="col-span-6 sm:col-span-6">
                                        <x-jet-label for="editing.surname" value="{{ __('Apellidos') }}" />
                                        <x-jet-input id="editing.surname" type="text" class="mt-1 block w-full"
                                            wire:model.defer="editing.surname" autocomplete="surname" />
                                        <x-jet-input-error for="editing.surname" class="mt-2" />
                                    </div>
                                    <!-- Email -->
                                    <div class="col-span-6 sm:col-span-6">
                                        <x-jet-label for="editing.email" value="{{ __('Email') }}" />
                                        <x-jet-input id="editing.email" type="email" class="mt-1 block w-full"
                                            wire:model.defer="editing.email" autocomplete="username" />
                                        <x-jet-input-error for="editing.eemail" class="mt-2" />

                                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                                                !$this->user->hasVerifiedEmail())
                                            <p class="text-sm mt-2">
                                                {{ __('Your email address is unverified.') }}

                                                <button type="button"
                                                    class="underline text-sm text-gray-600 hover:text-gray-900"
                                                    wire:click.prevent="sendEmailVerification">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if ($this->verificationLinkSent)
                                                <p v-show="verificationLinkSent"
                                                    class="mt-2 font-medium text-sm text-green-600">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                    <!-- faculty -->
                                    <div class="col-span-6 sm:col-span-6">
                                        <x-jet-label for="editing.faculty_id" value="{{ __('Facultad') }}" />

                                        <x-input.select wire:model.defer="editing.faculty_id" class="font-medium"
                                            wire:change="selectDepartments" id="editing.faculty_id" name="faculty_id">
                                            <option value="">selecione una Facultad</option>
                                            @foreach ($faculties as $faculty)
                                                <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                            @endforeach
                                        </x-input.select>
                                        <x-jet-input-error for="editing.faculty_id" class="mt-2" />
                                    </div>
                                    <!-- Departments -->
                                    @if (count($this->departments) > 0)
                                        <div class="col-span-6 sm:col-span-6">
                                            <x-jet-label for="department_id" value="{{ __('Departamento') }}" />

                                            <x-input.select wire:model.defer="editing.department_id" class="font-medium"
                                                id="department_id" name="department_id">
                                                <option value="">--- Ninguno ---</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        wire:key="department-{{ $department->id }}">{{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </x-input.select>
                                            <x-jet-input-error for="department_id" class="mt-2" />
                                        </div>
                                    @endif
                                    <!--Role-->

                                    <div class="col-span-6 lg:col-span-6">
                                        <x-jet-label value="{{ __('Role') }}" />
                                        <x-jet-input-error for="role" class="mt-2" id="role" />
                                        <div class="mt-1 border border-gray-200 rounded-lg cursor-pointer">
                                            @foreach ($roles as $index => $role)
                                                <div class="px-4 py-3 {{ $index > 0 ? 'border-t border-gray-200' : '' }}"
                                                    wire:click="addRole('{{ $role->id }}')">
                                                    <div>
                                                        <!-- Role Name -->
                                                        <div class="flex items-center">
                                                            <div class="text-sm text-gray-600 ">
                                                                @switch($role->name)
                                                                    @case('admin')
                                                                        {{ mb_strtoupper('Administrador') }}
                                                                    @break

                                                                    @case('commission')
                                                                        {{ mb_strtoupper('Comisión') }}
                                                                    @break

                                                                    @case('user')
                                                                        {{ mb_strtoupper('usuario') }}
                                                                    @break

                                                                    @default
                                                                        {{ $user->role }}
                                                                @endswitch
                                                            </div>
                                                            @if (in_array($role->id, $selectedRoles))
                                                                <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </x-slot>
                            <x-slot name="footer">
                                <x-button.danger wire:click="$set('showEditModal', false)">Cancelar</x-button.danger>
                                <x-button.success wire:click.prevent="save">Guardar</x-button.success>
                            </x-slot>
                        </x-modal.dialog>
                    </form>
                    <!--Confirm Delete faculty Modal-->
                    <form>
                        <x-modal.confirmation wire:model.defer="showDeleteModal">
                            <div class="grid grid-cols-6 gap-6">
                                <x-slot name="title">Eliminar Facultad </x-slot>
                                <x-slot name="content">
                                    ¿Estas seguro de eliminar esta faculty? Esta acción es irreversible
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
        <x-modal.dialog wire:model.defer="showModalDetailUser">
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
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Foto </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    
                                   @if ($detailUser && (!is_null($detailUser->profile_photo_url) || !empty($detailUser->profile_photo_path)))
                                    <div class="mt-1 flex items-center">
                                        <img class="inline-block h-14 w-14 rounded-full"
                                            src="{{ asset($detailUser->profile_photo_url) }}"
                                            alt="">
                                    </div>
                                @else
                                    No asignado
                                @endif

                                                    
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ mb_strtoupper($detailUser->name ?? 'no') }}, {{ mb_strtoupper($detailUser->surname ?? 'no') }}

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Código </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ mb_strtoupper($detailUser->code ?? 'no') }}
                                </dd>
                            </div>
                           
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Facultad</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailUser)
                                    {{ mb_strtoupper($detailUser->faculties->name??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                  @if ($detailUser)
                                    {{ mb_strtoupper($detailUser->departments->name??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif
                                </dd>
                            </div>
                           
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Correo</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                                    @if ($detailUser)
                                    {{ mb_strtoupper($detailUser->email??'no asignado',) }}
                                    @else
                                    No tiene información disponible
                                    @endif

                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Rol</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                               @if (!empty($detailUser->roles))
                                    @foreach ($detailUser->roles as $role)
                                                    @switch($role->name)
                                                        @case('admin')
                                                            {{ mb_strtoupper('Administrador') }} @if (!$loop->last)
                                                                , <br>
                                                            @endif
                                                        @break

                                                        @case('commission')
                                                            {{ mb_strtoupper('Comisión') }} @if (!$loop->last)
                                                                , <br>
                                                            @endif
                                                        @break

                                                        @case('user')
                                                            {{ mb_strtoupper('usuario') }} @if (!$loop->last)
                                                                , <br>
                                                            @endif
                                                        @break

                                                        @default
                                                            {{ $datailUser->role }}
                                                    @endswitch
                                                @endforeach
                               @else
                                   
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

            </main>
</div>
