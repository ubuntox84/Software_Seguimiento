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

            </div>
            <div class="flex items-center">
                <x-toogle-profile-mobile />

            </div>
        </div>
    </div>

<main class=" pb-10 lg:py-12 lg:px-8 space-y-6">
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                ¿Qué vas a solicitar?
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
        </div>
    </div>
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5 ">

        <div class="overflow-hidden bg-white  sm:rounded-md lg:col-span-12 space-y-6">
            <div class="">
                <h4 class="text-xl font-bold leading-7 text-gray-500 sm:truncate sm:text-xl sm:tracking-tight">
                    Lista de Solicitudes
                </h4>
                <div class="flex items-center text-sm text-gray-400">

                    Todos
                </div>
            </div>
            <div class="rounded-md bg-blue-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: mini/information-circle -->
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1 md:flex md:justify-between">
                        <p class="text-sm text-blue-700">
                            Ver mis Solicitudes.
                        </p>
                        <p class="mt-3 text-sm md:mt-0 md:ml-6">
                            <a href="{{ route('petition-list') }}"
                                class="whitespace-nowrap font-medium text-blue-700 hover:text-blue-600">
                                ir
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <ul role="list" class="">
                @forelse ($petitions as $petition)
                    <li>
                        <a href="{{ route('petition-form', ['petition' => $petition]) }}"
                            class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center ">
                                    <x-icon.document-check class="mr-1.5 h-5 w-5 flex-shrink-0 text-green-600" />
                                    <p class="truncate text-sm font-medium text-indigo-600">
                                        {{ mb_strtoupper($petition->name) }}
                                    </p>
                                    <div class="ml-2 flex flex-shrink-0">

                                        @if ($petition->state == 1)
                                            <span
                                                class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Disponible</span>
                                        @else
                                            <span
                                                class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">No
                                                Disponible</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <!-- Heroicon name: mini/users -->


                                            {{ $petition->description }}
                                        </p>

                                    </div>
                                </div>
                        </a>
                    </li>
                @empty
                @endforelse


            </ul>

        </div>

    </div>
</main>
<!--end main-->
</div>
