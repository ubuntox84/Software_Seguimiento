<div>
    <x-button.secondary wire:click="$toggle('showModal')" class="flex items-center space-x-2">
        <x-icon.upload /> <span>Importar</span>
    </x-button.secondary>

    <form wire:submit.prevent="import">
        <x-modal.dialog wire:model="showModal">
            <x-slot name="title">Importar Datos</x-slot>

            <x-slot name="content">
                <div class="space-y-6 py-12">
                    <div class="flex flex-col items-center justify-center ">
                        <x-radio-inline>
                            <x-slot name="title">
                                ¿Que desea importar?
                            </x-slot>
                            <x-slot name="header">
                            
                            </x-slot>
                            <div class="flex items-center space-x-2">
                                <x-jet-input class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    id="area" wire:model.lazy='importCourseArea' value="area" type="radio" />
                                <x-jet-label class="ml-3 block text-sm font-medium text-gray-700"
                                    value="Área de Conocimiento" id="area" for="area" />
                            </div>
                            <div class="flex items-center space-x-2">
                                <x-jet-input class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    id="course" wire:model.lazy='importCourseArea' value="course" type="radio" />
                                <x-jet-label class="ml-3 block text-sm font-medium text-gray-700" value="Cursos"
                                    id="course" for="course" />
                            </div>

                            <div class="flex items-center space-x-2">
                                <x-jet-input class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    id="both" wire:model.lazy='importCourseArea' value="both" type="radio" />
                                <x-jet-label class="ml-3 block text-sm font-medium text-gray-700" value="Área y Cursos"
                                    id="both" for="both" />
                            </div>
                             <div class="flex items-center space-x-2">
                                <x-jet-input class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    id="freeActivity" wire:model.lazy='importCourseArea' value="freeActivity" type="radio" />
                                <x-jet-label class="ml-3 block text-sm font-medium text-gray-700" value="Actividad Libre"
                                    id="freeActivity" for="freeActivity" />
                            </div>
                        </x-radio-inline>
                    </div>
                    {{-- @unless ($upload) --}}
                    @if ($this->importCourseArea)
                    <div class="flex flex-col items-center justify-center ">
                        <div class="flex items-center space-x-2 text-xl">
                            <x-icon.upload class="text-cool-gray-400 h-8 w-8" />
                            <x-input.file-upload wire:model="upload" id="upload"><span
                                    class="text-gray-400 font-bold">xlsx Archivos</span></x-input.file-upload>
                            <span class="text-gray-500 text-sm">{{ $nameUpload }}</span>
                        </div>
                        @error('upload') <div class="mt-3 text-red-500 text-sm">{{ $message }}</div> @enderror
                    </div>
                    @endif

                </div>
                
            </x-slot>

            <x-slot name="footer">
                <x-button.danger wire:click="cancelForm">Cancel</x-button.danger>

                <x-button.success type="submit">Import</x-button.success>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>