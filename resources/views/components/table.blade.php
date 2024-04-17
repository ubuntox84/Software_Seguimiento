@props(['clasesBody'=>'bg-white divide-y divide-cool-gray-200','overX'=>''])

<div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 {{ $overX }}">
    <table class="min-w-full divide-y divide-cool-gray-200">
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody {{ $attributes->merge(['class' => $clasesBody]) }}>
            {{ $body }}
        </tbody>
    </table>
</div>