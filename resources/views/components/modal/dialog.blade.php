{{-- @props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}  >
    <div class="px-6 py-4 ">
        <div class="text-lg">
            {{ $title }}
        </div>

        <div class="mt-4  h-auto max-h-64 overflow-y-auto  scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-200 px-4 ">
            {{ $content }}
        </div>
    </div>

    <div class="px-6 py-4 bg-gray-50 text-right  ">
        {{ $footer }}
    </div>
</x-modal> --}}
@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900 dark:text-gray-700">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-gray-600 dark:text-gray-600  h-auto max-h-96 overflow-y-auto  scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-200 px-4">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row space-x-2 justify-end px-6 py-4 bg-gray-100 dark:bg-gray-100 text-right">
        {{ $footer }}
    </div>
</x-modal>