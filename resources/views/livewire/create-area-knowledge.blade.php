<div x-cloak x-show="OpenFormCreateArea" 

    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="relative z-10"
    aria-labelledby="modal-title" role="dialog" aria-modal="true"
    x-init="
    Livewire.on('closeModalCreateArea', message => {
        OpenFormCreateArea =false
    })
    "
    >

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 ">
        <div x-cloak x-show="OpenFormCreateArea" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <div class="relative py-8 px-6 transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div x-cloak x-show="OpenFormCreateArea" class="mt-5 md:col-span-2 md:mt-0">
                    <form wire:submit.prevent="createAreaKnowledge">
                        @csrf
        
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Código</label>
                                        <input wire:model='code' type="text" name="first-name" id="first-name"
                                            autocomplete="given-name"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('code')
                                        <p class="mt-1 text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
        
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="last-name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input wire:model='name' type="text" name="last-name" id="last-name"
                                            autocomplete="family-name"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('name')
                                        <p class="mt-1 text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
        
        
        
        
                                </div>
                            </div>
        
                            <div class="px-4 py-3 text-right sm:px-6">
        
                                <button wire:click.prevent="cancelFormArea"
                                    class="justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Registrar
                                </button>
                            </div>
        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>