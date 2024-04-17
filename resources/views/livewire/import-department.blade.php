<div>
    <x-button.secondary wire:click="$toggle('showModal')" class="flex items-center space-x-2"><x-icon.upload /> <span>Importar</span></x-button.secondary>

    <form wire:submit.prevent="import">
        <x-modal.dialog wire:model="showModal">
            <x-slot name="title">Importar Deapartamentos</x-slot>

            <x-slot name="content">
                {{-- @unless ($upload) --}}
                <div class="py-12 flex flex-col items-center justify-center ">
                    <div class="flex items-center space-x-2 text-xl">
                        <x-icon.upload class="text-cool-gray-400 h-8 w-8" />
                        <x-input.file-upload wire:model="upload" id="upload"><span class="text-gray-400 font-bold">xlsx Archivos</span></x-input.file-upload>
                        <span class="text-gray-500 text-sm">{{ $nameUpload }}</span>
                    </div>
                    @error('upload') <div class="mt-3 text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>
               
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="cancelForm">Cancel</x-button.secondary>

                <x-button.primary type="submit">Import</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>



