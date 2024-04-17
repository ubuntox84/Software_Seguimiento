<div x-cloak x-show="OpenFormCreateCourse" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="relative z-10"
    aria-labelledby="modal-title" role="dialog" aria-modal="true" x-init="
    Livewire.on('loadDataCourses', message => {
        OpenFormCreateCourse =true
    })
    
    Livewire.on('closeModalCreateCurso', message => {
        OpenFormCreateCourse =false
    })
    
    ">


    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10  overflow-auto">
        <div x-cloak x-show="OpenFormCreateCourse" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="flex   min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <div
                class=" relative w-full h-full max-w-2xl md:h-auto py-8 px-6 transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div lass="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6 ">



                    <form wire:submit.prevent="createCourse" class="space-y-8 divide-y divide-gray-200">
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="email-address" class="block text-sm font-medium text-gray-700">Área
                                            de conocimiento</label>
                                        <select wire:model.defer="area_knowledge_id" type="text" name="email-address"
                                            id="email-address" autocomplete="email"
                                            class=" mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            <option selected>seleccione área de conocimiento</option>
                                            @forelse ($areaKnowledges as $area)
                                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @empty
                                            <option>No hay registros</option>

                                            @endforelse
                                        </select>
                                        @error('area_knowledge_id')
                                        <p class="text-red-500 ">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name"
                                            class="block text-sm font-medium text-gray-700">Código</label>
                                        <input wire:model="code" type="text" name="first-name" id="first-name"
                                            autocomplete="given-name"
                                            class=" block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('code')
                                        <p class="text-red-500 ">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="last-name"
                                            class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input wire:model="name" type="text" name="last-name" id="last-name"
                                            autocomplete="family-name"
                                            class=" block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('name')
                                        <p class="text-red-500 ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="last-name" class="block text-sm font-medium text-gray-700">Horas
                                            Teóricas</label>
                                        <input wire:model="theoreticalHour" type="number" name="last-name"
                                            id="last-name" autocomplete="family-name"
                                            class=" block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('theoreticalHour')
                                        <p class="text-red-500 ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Horas
                                            Prácticas
                                        </label>
                                        <input wire:model="practicalHour" type="number" name="first-name"
                                            id="first-name" autocomplete="given-name"
                                            class=" block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('practicalHour')
                                        <p class="text-red-500 ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Creditos
                                        </label>
                                        <input wire:model="credits" type="number" name="first-name" id="first-name"
                                            autocomplete="given-name"
                                            class=" block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('credits')
                                        <p class="text-red-500 ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Tipo
                                            Curso </label>
                                        <select wire:model="typeCourse" id="location" name="location"
                                            class=" block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            <option selected>seleccione un tipo de curso</option>
                                            <option value="Actividad Libre">Actividad Libre</option>
                                            <option value="Carrera">Carrera</option>

                                        </select>
                                        @error('typeCourse')
                                        <p class="text-red-500 ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Ciclo
                                        </label>
                                        <input wire:model="cycle" type="number" name="first-name" id="first-name"
                                            autocomplete="given-name"
                                            class=" block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('cycle')
                                        <p class="text-red-500 ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">

                                <button type="submit"
                                    class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-2 text-sm font-medium leading-4 text-white hover:bg-green-500 focus:outline-none focus:ring-2 transition ease-in-out duration-150 mt-2 disabled:opacity-50">
                                    <svg wire:loading wire:target="createCurricula"
                                        class="animate-spin -ml-1 mr-3 h-2 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4">
                                        </circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span>
                                        Registrar
                                    </span>
                                </button>
                                <button wire:click="cancelFormCourse" type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-red-800 px-3 py-2 text-sm font-medium leading-4 text-white hover:bg-red-500 focus:outline-none focus:ring-2 ">
                                    Cancelar
                                </button>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>