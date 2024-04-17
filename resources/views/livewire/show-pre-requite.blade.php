<div x-data="{ showAdd:false }">
    <x-button.success-icon wire:click="$toggle('showModal')" class="flex items-center space-x-2">
        <x-icon.list-bullet class="text-green-600" />
    </x-button.success-icon>

    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model="showModal" :id="'myModal'">
            <x-slot name="title">
                {{-- <div class="space-y-4">
                    <div class="flex space-x-6">
                        <h1 class="text-gray-900 font-bold">Curso: </h1><span
                            class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800">{{
                            mb_strtoupper($course->name) }}</span>

                    </div>

                    <div class="flex space-x-6">
                        <p class="text-gray-900  font-bold"> Código:</p> <span
                            class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800">{{
                            mb_strtoupper($course->code) }}</span>
                    </div>
                    @if ($curriculaState->state==1)
                    <div class="flex">
                        <x-button.success x-cloak x-show="!showAdd" @click="showAdd=!showAdd">
                            <x-icon.plus>

                            </x-icon.plus>
                            Agregar
                        </x-button.success>
                        <x-button.secondary x-cloak x-show="showAdd" @click="showAdd=!showAdd">
                            <x-icon.minus-circle>

                            </x-icon.minus-circle>
                            Ocultar
                        </x-button.secondary>
                    </div>
                    @endif

                </div> --}}
            </x-slot>
            <x-slot name="content">

                <div class="space-y-6">
                   
                       
                        <div x-xloak x-show="showAdd">
                            {{-- <x-select-component  name="course_id" id="select2-{{ $course->id }} "  
                                wire:model="course_id" :options="$this->courses" /> --}}
                      
                                <x-input.select wire:model="add_course_id" wire:change="handleChange($event.target.value)">
                                    <option value="" selected>selecione Curso</option>
                                    @foreach ($courses as $courseList)
                                        <option value="{{ $courseList->id }}" >{{ $courseList->name }}</option>
                                    @endforeach
                                </x-input.select> 
                        </div>
                    @if ($errors->any())
                    <div>
                        <div class="rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: mini/x-circle -->
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="flex">
                                        <h3 class="text-sm font-medium text-red-800">Hay {{ $errors->count() }} {{
                                            $errors->count()>1?'errores':'error' }} </h3>
                                    </div>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul role="list" class="list-disc space-y-1 pl-5">
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif
                    @if ($selectCourses)
                    <div >
                     <ul role="list" class="divide-y divide-gray-200">
                         @foreach ($courses->whereIn('id',$selectCourses) as $courseAdd)
                         <li class="flex justify-between items-center py-2 pl-2  pr-2">
                             <div >
                               <p class="text-sm font-medium text-gray-900">{{ $courseAdd->name }}</p>
                               <p class="text-sm text-gray-500">{{ $courseAdd->code }}</p>
                             </div>
                             <div>
                                <x-icon.trash class="text-red-800 pointer hover:text-red-500" wire:click.prevent="removeSelectCourse({{$courseAdd->id}})">
                                    
                                </x-icon.trash>
                             </div>
                           </li>
                         @endforeach
                     </ul>
                    </div>
                     @endif
                    <div>
                        
                        <x-table>
                            <x-slot name="head">
                                <x-table.heading class="whitespace-nowrap" scope="col">Prerrequisito </x-table.heading>
                                <x-table.heading class="whitespace-nowrap" scope="col">Código</x-table.heading>
                                @if ($curriculaState->state==1)
                                <x-table.heading>opciónes</x-table.heading>
                                @endif
                            </x-slot>
                            <x-slot name="body">
                                @if($course->prerequisites->count() > 0)

                                @forelse ($course->prerequisites as $course)


                                <x-table.row wire:loading.class.delay="opacity-50">


                                    <x-table.cell class="whitespace-nowrap text-left">{{ mb_strtoupper( $course->name)
                                        }}</x-table.cell>
                                    <x-table.cell class="whitespace-nowrap text-left">{{ mb_strtoupper( $course->code)
                                        }}</x-table.cell>
                                    @if ($curriculaState->state==1)
                                    <x-table.cell class="pl-9">
                                        <div class="space-x-2 ">
                                            <div class="text-center">
                                                <x-button.danger-icon
                                                    wire:click.prevent="deletePrerequisite({{ $course->id }})">
                                                    <x-icon.trash text="yellow"></x-icon.trash>
                                                </x-button.danger-icon>
                                            </div>
                                        </div>
                                    </x-table.cell>
                                    @endif
                                </x-table.row>


                                @empty
                                <x-table.row>
                                    <x-table.cell colspan="4">
                                        <div class="flex justify-center items-center">
                                            <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                            <span class="font-medium py-8 text-neutral-500 text-xl">
                                                datos no encontrados...
                                            </span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endforelse
                                @else
                                <x-table.row>
                                    <x-table.cell colspan="4">
                                        <div class="flex justify-center items-center">
                                            <x-icon.inbox class="h-8 w-8 text-neutral-400 space-x-2" />
                                            <span class="font-medium py-8 text-neutral-500 text-xl">
                                                datos no encontrados...
                                            </span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endif
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="cancelForm" @click="showAdd=false">Cancel</x-button.secondary>
                @if ($curriculaState->state==1 && $selectCourses)
                <x-button.success type="submit">Agregar</x-button.success>
                @endif
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
@push('style')
<style>
    /* .mylabel {
  @apply text-sm text-blue-300 text-bold;
}
 .select2-dropdown {
  background-color: white;
  border: 1px solid #aaa;
  border-radius: 4px;
  box-sizing: border-box;
  display: block;
  position: absolute;
  left: -100000px;
  width: 100%;
  z-index: 1051; }
 .select2-dropdown {
  @apply absolute block w-auto box-border bg-white border-solid border-2 border-gray-600 z-50 float-left;
  } */
</style>
@endpush
@push('scripts')
<script>
    //     window.addEventListener('name-updated', event => {
//         $('.select2').select2();
//      console.log('fdfdf');
// })
//      Livewire.on('name-updated', postId => {
//             console.log('fdfdf');
//             $('.select2').select2();
// })
//     $(document).ready(function() {
//         $('.select2').select2();
       

//     $('#select2Id').on('change', function (e) {
//             var data = $('#select2Id').select2("val");
//             @this.set('course_id', data);
//     });
//     Livewire.on('name-updated', postId => {
//         $('#select2Id').val(null).trigger("change")
// })
// //     window.addEventListener('name-updated', event => {
// //         // $('#select2-{{ $course->id }}').select2("val", "");
// //         $('#select2-{{ $course->id }}').val(null).trigger("change");
// //     // console.log('sfsdf');
// // })
// });

//   $(document).ready(function () {
      
//         $('#select2-dropdown').select2({
//             placeholder: 'Seleccione cursos'
//         });
//         $('#select2-dropdown').on('change', function (e) {
//             var data = $('#select2-dropdown').select2("val");
//             @this.set('course_id', data);
//         });
//     });
</script>
@endpush