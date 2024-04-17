@props([
'placeholder' => null,
'trailingAddOn' => null,
'addClass'=>false
])

<div class="flex {{ $addClass }}">
    <select  {{ $attributes->merge(['class'=>' block w-full rounded-md border-gray-300
        py-2 pl-3 pr-10 text-base text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm'])}}>
        @if ($placeholder)
        <option disabled value="">{{ $placeholder }}</option>
        @endif

        {{ $slot }}
    </select>

    @if ($trailingAddOn)
    {{ $trailingAddOn }}
    @endif
    </select>
</div>