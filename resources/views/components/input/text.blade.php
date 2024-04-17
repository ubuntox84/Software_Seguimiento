@props([
    'leadingAddOn' => false,
    'icon'=>false,
    'addClass'=>false,
])

<div class=" mt-1 flex rounded-md shadow-sm {{ $addClass }}">
    @if ($leadingAddOn)
    
    <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">{{ $leadingAddOn }}</span>
     
    @endif
    @if ($icon)
    <div class="pointer-events-none mt-1 absolute inset-y-0 left-0 flex items-center pl-3">
        {{ $icon }}
    </div>
    @endif
    <input {{ $attributes->merge(['class'=>'block w-full rounded-md border-gray-300 pl-3 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm'. ($leadingAddOn ? ' rounded-none rounded-r-md' : '')])}} >
</div>

