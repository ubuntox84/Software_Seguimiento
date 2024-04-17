<div>
    <x-button.secondary wire:click="$toggle('showModal')" class="flex items-center space-x-2"><x-icon.upload /> <span>Importar</span></x-button.secondary>

    <form wire:submit.prevent="import">
        <x-modal.dialog wire:model="showModal">
            <x-slot name="title">Importar Currícula</x-slot>

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
                {{-- @else
                <div>
                    <x-input.group inline borderless for="name" label="Nombre" :error="$errors->first('fieldColumnMap.name')">
                        <x-input.select wire:model="fieldColumnMap.name" id="name">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as  $column)
                                <option >{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                     <x-input.group inline borderless for="resolution" label="Resolución" :error="$errors->first('fieldColumnMap.resolution')">
                        <x-input.select wire:model="fieldColumnMap.resolution" id="resolution">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                                <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group inline borderless for="state" label="Estado" :error="$errors->first('fieldColumnMap.state')">
                        <x-input.select wire:model="fieldColumnMap.state" id="state">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                                <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group inline borderless for="date_approved" label="Fecha Aprobación" :error="$errors->first('fieldColumnMap.date_approved')">
                        <x-input.select wire:model="fieldColumnMap.date_approved" id="date_approved">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                                <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                    <x-input.group inline borderless for="date_active" label="Fecha Activo" :error="$errors->first('fieldColumnMap.date_active')" >
                        <x-input.select wire:model="fieldColumnMap.date_active" id="date_active">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                                <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                    <x-input.group inline borderless for="date_inactive" label="Fecha Inactivo" :error="$errors->first('fieldColumnMap.date_inactive')" >
                        <x-input.select wire:model="fieldColumnMap.date_inactive" id="date_inactive">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                                <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                  
                </div>
                @endif --}}
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="cancelForm">Cancel</x-button.secondary>

                <x-button.primary type="submit">Import</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
