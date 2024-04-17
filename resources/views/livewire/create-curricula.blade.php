<div x-show="showFormCreate" x-cloak x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95" 
    class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6 ">

            <form wire:submit.prevent="createCurricula" class="grid grid-cols-6 gap-6">
                @csrf
               <x-input.group label="Nombre" for="name"  clases="col-span-6 sm:col-span-6" :error="$errors->first('name')">
                    <x-input.text wire:model="name" id="name" type="text" />
               </x-input.group>
              
                <x-input.group label="Fecha Aprobación"   for="date_approved" clases="col-span-6 sm:col-span-2" :error="$errors->first('date_approved')">
                    <x-input.text wire:model="date_approved" id="date_approved" type="date" />
               </x-input.group>

               <x-input.group label="Resolución"   for="resolution" clases="col-span-6 sm:col-span-4" :error="$errors->first('resolution')">
                    <x-input.text wire:model="resolution" id="resolution" type="text" />
                </x-input.group>
              
                <x-input.group label="Fecha Activa"   for="date_active" clases="col-span-6 sm:col-span-2" :error="$errors->first('date_active')">
                    <x-input.text wire:model="date_active" id="date_active" type="date" />
               </x-input.group>
             
                <x-input.group label="Fecha Inactivo"   for="date_inactive" clases="col-span-6 sm:col-span-4" :error="$errors->first('date_inactive')">
                    <x-input.text wire:model="date_inactive" id="date_inactive" type="date" />
                </x-input.group>

                <div class="col-span-6 sm:col-span-3 lg:col-span-4">
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-2 text-sm font-medium leading-4 text-white hover:bg-green-500 focus:outline-none focus:ring-2 transition ease-in-out duration-150 mt-2 disabled:opacity-50">
                        <svg wire:loading wire:target="createCurricula"
                            class="animate-spin -ml-1 mr-3 h-2 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>
                            Registrar
                        </span>
                    </button>
                    <button @click.prevent="$wire.cancelForm;showFormCreate=false" type="button"
                        class="inline-flex items-center rounded-md border border-transparent bg-red-800 px-3 py-2 text-sm font-medium leading-4 text-white hover:bg-red-500 focus:outline-none focus:ring-2 ">
                        Cancelar
                    </button>

                </div>
            </form>
</div>