@props(['forIn'=>false])

@if ($forIn)
<div class="relative flex items-start">
    <div class="flex h-5 items-center">
      <input  {{ $attributes }} id="{{ $forIn }}" 
      aria-describedby="candidates-description" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" type="checkbox">
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $forIn }}" id="{{ $forIn }}" class="font-medium text-gray-700">{{ $slot }}</label>
    </div>
</div>
@else
<div class="flex h-5 items-center">
    <input  {{ $attributes }}  
    aria-describedby="candidates-description" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" type="checkbox">
  </div>    
@endif


