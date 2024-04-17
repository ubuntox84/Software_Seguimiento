<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
            <!-- Profile Photo File Input -->
            <input type="file" class="hidden" id="photo"wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

            <x-jet-label for="photo" value="{{ __('Photo') }}" />

            <!-- Current Profile Photo -->
            <div class="mt-2" x-show="! photoPreview">
                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                    class="rounded-full h-20 w-20 object-cover">
            </div>

            <!-- New Profile Photo Preview -->
            <div class="mt-2" x-show="photoPreview" style="display: none;">
                <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                    x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Select A New Photo') }}
            </x-jet-secondary-button>

            @if ($this->user->profile_photo_path)
            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-jet-secondary-button>
            @endif

            <x-jet-input-error for="photo" class="mt-2" />
        </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-3">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <!-- LastName -->
        <div class="col-span-6 sm:col-span-3">
            <x-jet-label for="surname" value="{{ __('Apellido') }}" />
            <x-jet-input id="surname" type="text" class="mt-1 block w-full" wire:model.defer="state.surname"
                autocomplete="surname" />
            <x-jet-input-error for="surname" class="mt-2" />
        </div>
        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email"
                autocomplete="username" />
            <x-jet-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && !
            $this->user->hasVerifiedEmail())
            <p class="text-sm mt-2">
                {{ __('Your email address is unverified.') }}

                <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900"
                    wire:click.prevent="sendEmailVerification">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if ($this->verificationLinkSent)
            <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to your email address.') }}
            </p>
            @endif
            @endif
        </div>

        <!-- Code -->
        <div class="col-span-6 sm:col-span-2">
            <x-jet-label for="code" value="{{ __('Code') }}" />
            <x-jet-input id="code" type="text" class="mt-1 block w-full" wire:model.defer="state.code"
                placeholder="0020100438" autocomplete="code" />
            <x-jet-input-error for="code" class="mt-2" />
        </div>
        {{-- @json($departments) --}}
        <!-- faculty -->
        <div class="col-span-6 sm:col-span-6">
            <x-jet-label for="faculty_id" value="{{ __('Facultad') }}" />

            <x-input.select wire:model.defer="state.faculty_id" class="font-medium" id="faculty_id" name="faculty_id" wire:change="selectDepartments">
                <option value="">selecione una Facultad</option>
                @foreach ($faculties as $faculty)
                <option value="{{ $faculty->id }}" wire:key="faculty-{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
            </x-input.select>
            <x-jet-input-error for="faculty_id" class="mt-2" />
        </div>
        <!-- Departments -->
        @if (count($this->departments)>0)
        <div class="col-span-6 sm:col-span-6">
            <x-jet-label for="department_id" value="{{ __('Departamento') }}" />

            <x-input.select wire:model.defer="state.department_id" class="font-medium" id="department_id" name="department_id">
                <option value="">--- Ninguno ---</option>
                @foreach ($departments as $department)
                <option value="{{ $department->id }}" wire:key="department-{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </x-input.select>
            <x-jet-input-error for="department_id" class="mt-2" />
        </div>

        @endif
        <!--Role-->
        @if (auth()->user()->hasRole('admin'))
        <div class="col-span-6 lg:col-span-3">
            <x-jet-label  value="{{ __('Role') }}" />
            {{-- <input hidden type="" id="role"> --}}
            <x-jet-input-error for="role" class="mt-2" id="role"/>
            <div class="mt-1 border border-gray-200 rounded-lg cursor-pointer">
                @foreach ($roles as $index =>$role)
                <div class="px-4 py-3 {{ $index > 0 ? 'border-t border-gray-200' : '' }}"
                    wire:click="addRole('{{ $role->id}}')">
                    <div>
                        <!-- Role Name -->
                        <div class="flex items-center">
                            <div class="text-sm text-gray-600 ">
                                @switch($role->name)
                                @case('admin')
                                {{ mb_strtoupper( 'Administrador') }}
                                @break

                                @case('commission')
                                {{ mb_strtoupper( 'Comisión') }}
                                @break

                                @case('user')
                                {{ mb_strtoupper( 'usuario') }}
                                @break
                                @default
                                {{ $user->role }}
                                @endswitch
                            </div>

                            @if (in_array($role->id,$selectedRoles))
                            <svg class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @endif
                        </div>

                        <!-- Role Description -->
                        {{-- <div class="mt-2 text-xs text-gray-600">
                            es una descripcion breve
                        </div> --}}
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        @endif

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>