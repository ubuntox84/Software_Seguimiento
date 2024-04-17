@props([
'clases'=>'',
'label',
'for',
'error' => false,
'helpText' => false,
'inline' => false,
'paddingless' => false,
'borderless'=> false

])
@if ($inline)
<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 {{ $borderless ? '' : ' sm:border-t ' }} sm:border-gray-200 {{ $paddingless ? '' : ' sm:pt-5 ' }}">
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
        {{ $label }}
    </label>
    <div class="mt-1 sm:col-span-2 sm:mt-0">
        {{ $slot }}
        @if ($error)
        <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
        @endif

        @if ($helpText)
        <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
        @endif
    </div>
</div>

@else
<div  class="{{ $clases }}">
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1  relative rounded-md ">
        {{ $slot }}
        @if ($error)
        <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
        @endif

        @if ($helpText)
        <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
        @endif
    </div>
</div>
@endif