<div>
    <div wire:ignore x-data="{ }" x-init="() => {
	$('.select2').select2({
        placeholder: 'seleccione Curso',
        allowClear: true
    });
   
	$('.select2').on('change', function(e) {
        let elementName = $(this).attr('name');
	    @this.set(elementName, $(this).val());
        
		Livewire.hook('message.processed', (m, component) => {
			$('.select2').select2({
                placeholder: 'seleccione Curso',
                allowClear: true
            });
            
		})
       
   

	})
{{--          
    Livewire.on('select2Cleared',() =>  {
        console.log('LLL')
        $('.select2').val(null).trigger('change')
    }) --}}
    
}">
{{-- {{ dd($attributes) }} --}}
        <select class="select2" {{$attributes}} style="width: 100%;"    >
            <option value="">Selecione curso</option>
            @foreach ($options as $option)
            <option value="{{$option->id}}">{{$option->name}}</option>
            @endforeach
        </select>
    </div>
</div>