<button
    {{ $attributes->merge(['type' => 'button',
        'class' => ' text-sm leading-5 font-medium focus:outline-none  focus:underline transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}
>
    {{ $slot }}
</button>
