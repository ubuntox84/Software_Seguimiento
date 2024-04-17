<div class="flex flex-col  lg:pl-64">

    <main class="flex-1 sm:px-6 lg:px-8  py-4">
        <form class="space-y-8 divide-y divide-gray-200" wire:submit.prevent="submit">
            <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                <div class="space-y-6 sm:space-y-5">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Configuración</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Esta información se mostrará en el archivo word
                            de la solicitud.</p>
                    </div>

                    <div class="space-y-6 sm:space-y-5">
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="university"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Nombre
                                Universidad</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input id="university" name="university" type="text"
                                    wire:model.defer="configuration.university"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('configuration.university')
                                    <p class="mt-2 text-sm text-red-600" id="university">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="director"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Nombre Director</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input id="director" name="director" type="text"
                                    wire:model.defer="configuration.director"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('configuration.director')
                                    <p class="mt-2 text-sm text-red-600" id="director">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                         <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="president_name"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Nombre Presidente</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input id="director" name="president_name" type="text"
                                    wire:model.defer="configuration.president_name"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('configuration.president_name')
                                    <p class="mt-2 text-sm text-red-600" id="president_name">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="commission_name"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Nombre Comisión</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input id="commission_name" name="commission_name" type="text"
                                    wire:model.defer="configuration.commission_name"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('configuration.commission_name')
                                    <p class="mt-2 text-sm text-red-600" id="commission_name">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="abbreviation"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Abreviacion
                                Resolucion</label>
                            <div class="mt-1 sm:col-span-1 sm:mt-0">
                                <input id="abbreviation" name="abbreviation" type="text"
                                    wire:model.defer="configuration.abbreviation"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('configuration.abbreviation')
                                    <p class="mt-2 text-sm text-red-600" id="abbreviation">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="city"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Ciudad</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input id="city" name="city" type="text"
                                    wire:model.defer="configuration.city"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('configuration.city')
                                    <p class="mt-2 text-sm text-red-600" id="city">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="agreement_number"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Nro Acuerdo</label>
                            <div class="mt-1 sm:col-span-1 sm:mt-0">
                                <input id="agreement_number" name="agreement_number" type="number"
                                    wire:model.defer="configuration.agreement_number"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('configuration.agreement_number')
                                    <p class="mt-2 text-sm text-red-600" id="agreement_number">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="semester"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Semestre </label>
                            <div class="mt-1 sm:col-span-1 sm:mt-0">
                                <input id="semester" name="semester" type="text"
                                    wire:model.defer="configuration.semester"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('configuration.semester')
                                    <p class="mt-2 text-sm text-red-600" id="agreement_number">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="imgLeft"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">imagen encabezado
                                izquierdo</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <div
                                    class="flex max-w-lg justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                    <div class="space-y-1 text-center">
                                        @if (isset($configuration['left_image']) && !empty($configuration['left_image']) && empty($left_image))
                                            <img class="w-16 h-16 mx-auto my-auto"
                                                src="{{ asset($configuration['left_image']) }}">
                                        @elseif ($left_image)
                                            @if ($left_image)
                                                vista previa:
                                            @endif
                                            @if ($left_image instanceof \Illuminate\Http\UploadedFile)
                                                <img class="w-16 h-16 mx-auto my-auto"
                                                    src="{{ $left_image->temporaryUrl() }}">
                                            @endif
                                        @else
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        @endif


                                        <div class="flex text-sm text-gray-600">

                                            <label for="imgLeft"
                                                class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Subir imagen</span>
                                                <input id="imgLeft" accept="image/png,image/jpg"
                                                    wire:model.defer="left_image" name="imgLeft" type="file"
                                                    class="sr-only">
                                            </label>
                                            <p class="pl-1">encabezado izquierdo</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG</p>
                                        <div x-cloak x-show="isUploading">

                                            <p class="text-sm font-medium text-gray-900">subiendo
                                                imagen...</p>
                                            <div class="mt-2" aria-hidden="true">
                                                <div class="overflow-hidden rounded-full bg-gray-200">
                                                    <div class="h-2 rounded-full bg-green-600"
                                                        :style="'width: ' + progress + '%'"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('left_image')
                                    <p class="mt-2 text-sm text-red-600" id="university">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="imgRight"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">imagen encabezado
                                derecho</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <div
                                    class="flex max-w-lg justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                    <div class="space-y-1 text-center">

                                        @if (isset($configuration['right_image']) && !empty($configuration['right_image']) && empty($right_image))
                                            <img class="w-16 h-16 mx-auto my-auto"
                                                src="{{ asset($configuration['right_image']) }}">
                                        @elseif ($right_image)
                                            @if ($right_image)
                                                vista previa:
                                            @endif
                                            @if ($right_image instanceof \Illuminate\Http\UploadedFile)
                                                <img class="w-16 h-16 mx-auto my-auto"
                                                    src="{{ $right_image->temporaryUrl() }}">
                                            @endif
                                        @else
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        @endif


                                        <div class="flex text-sm text-gray-600">

                                            <label for="imgRight"
                                                class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Subir imagen</span>
                                                <input id="imgRight" accept="image/png,image/jpeg"
                                                    wire:model.defer="right_image" name="imgRight" type="file"
                                                    class="sr-only">
                                            </label>
                                            <p class="pl-1">encabezado derecho</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG</p>
                                        <div x-cloak x-show="isUploading">

                                            <p class="text-sm font-medium text-gray-900">subiendo
                                                imagen...</p>
                                            <div class="mt-2" aria-hidden="true">
                                                <div class="overflow-hidden rounded-full bg-gray-200">
                                                    <div class="h-2 rounded-full bg-green-600"
                                                        :style="'width: ' + progress + '%'"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('right_image')
                                    <p class="mt-2 text-sm text-red-600" id="university">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="logo_path"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Logo del sistema</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <div
                                    class="flex max-w-lg justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                    <div class="space-y-1 text-center">

                                        @if (isset($configuration['logo_path']) && !empty($configuration['logo_path']) && empty($logo_path))
                                            <img class="w-16 h-16 mx-auto my-auto"
                                                src="{{ asset($configuration['logo_path']) }}">
                                        @elseif ($logo_path)
                                            @if ($logo_path)
                                                vista previa:
                                            @endif
                                            @if ($logo_path instanceof \Illuminate\Http\UploadedFile)
                                                <img class="w-16 h-16 mx-auto my-auto"
                                                    src="{{ $logo_path->temporaryUrl() }}">
                                            @endif
                                        @else
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        @endif


                                        <div class="flex text-sm text-gray-600">

                                            <label for="logo_path"
                                                class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Subir imagen</span>
                                                <input id="logo_path" accept="image/png,image/jpeg"
                                                    wire:model.defer="logo_path" name="logo_path" type="file"
                                                    class="sr-only">
                                            </label>
                                            <p class="pl-1">encabezado derecho</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG</p>
                                        <div x-cloak x-show="isUploading">

                                            <p class="text-sm font-medium text-gray-900">subiendo
                                                imagen...</p>
                                            <div class="mt-2" aria-hidden="true">
                                                <div class="overflow-hidden rounded-full bg-gray-200">
                                                    <div class="h-2 rounded-full bg-green-600"
                                                        :style="'width: ' + progress + '%'"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('logo_path')
                                    <p class="mt-2 text-sm text-red-600" id="logo_path">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Use a permanent address where you can receive
                            mail.</p>
                    </div>
                    <div class="space-y-6 sm:space-y-5">
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="first-name"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">First name</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                            </div>
                        </div>

                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="last-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Last
                                name</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input type="text" name="last-name" id="last-name" autocomplete="family-name"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                            </div>
                        </div>

                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Email
                                address</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input id="email" name="email" type="email" autocomplete="email"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="country"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Country</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <select id="country" name="country" autocomplete="country-name"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>Mexico</option>
                                </select>
                            </div>
                        </div>

                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="street-address"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Street address</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input type="text" name="street-address" id="street-address"
                                    autocomplete="street-address"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="city"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">City</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input type="text" name="city" id="city" autocomplete="address-level2"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                            </div>
                        </div>

                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="region" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">State /
                                Province</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input type="text" name="region" id="region" autocomplete="address-level1"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                            </div>
                        </div>

                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="postal-code"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">ZIP / Postal
                                code</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code"
                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="space-y-6 divide-y divide-gray-200 pt-8 sm:space-y-5 sm:pt-10">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Notifications</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">We'll always let you know about important
                            changes, but you pick what else you want to hear about.</p>
                    </div>
                    <div class="space-y-6 divide-y divide-gray-200 sm:space-y-5">
                        <div class="pt-6 sm:pt-5">
                            <div role="group" aria-labelledby="label-email">
                                <div class="sm:grid sm:grid-cols-3 sm:items-baseline sm:gap-4">
                                    <div>
                                        <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700"
                                            id="label-email">By Email</div>
                                    </div>
                                    <div class="mt-4 sm:col-span-2 sm:mt-0">
                                        <div class="max-w-lg space-y-4">
                                            <div class="relative flex items-start">
                                                <div class="flex h-5 items-center">
                                                    <input id="comments" name="comments" type="checkbox"
                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="comments"
                                                        class="font-medium text-gray-700">Comments</label>
                                                    <p class="text-gray-500">Get notified when someones posts a comment
                                                        on a posting.</p>
                                                </div>
                                            </div>
                                            <div class="relative flex items-start">
                                                <div class="flex h-5 items-center">
                                                    <input id="candidates" name="candidates" type="checkbox"
                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="candidates"
                                                        class="font-medium text-gray-700">Candidates</label>
                                                    <p class="text-gray-500">Get notified when a candidate applies for
                                                        a job.</p>
                                                </div>
                                            </div>
                                            <div class="relative flex items-start">
                                                <div class="flex h-5 items-center">
                                                    <input id="offers" name="offers" type="checkbox"
                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="offers" class="font-medium text-gray-700">Offers</label>
                                                    <p class="text-gray-500">Get notified when a candidate accepts or
                                                        rejects an offer.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-6 sm:pt-5">
                            <div role="group" aria-labelledby="label-notifications">
                                <div class="sm:grid sm:grid-cols-3 sm:items-baseline sm:gap-4">
                                    <div>
                                        <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700"
                                            id="label-notifications">Push Notifications</div>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <div class="max-w-lg">
                                            <p class="text-sm text-gray-500">These are delivered via SMS to your mobile
                                                phone.</p>
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-center">
                                                    <input id="push-everything" name="push-notifications" type="radio"
                                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                    <label for="push-everything"
                                                        class="ml-3 block text-sm font-medium text-gray-700">Everything</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input id="push-email" name="push-notifications" type="radio"
                                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                    <label for="push-email"
                                                        class="ml-3 block text-sm font-medium text-gray-700">Same as
                                                        email</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input id="push-nothing" name="push-notifications" type="radio"
                                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                    <label for="push-nothing"
                                                        class="ml-3 block text-sm font-medium text-gray-700">No push
                                                        notifications</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="button"
                        class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancelar</button>
                    <button type="submit"
                        class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Guardar</button>
                </div>
            </div>
        </form>
    </main>
</div>
