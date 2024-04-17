<div>
    <div class="rounded-md bg-red-50 p-4 z-20 py-8">
        <div class="flex">
          <div class="flex-shrink-0">
            <!-- Heroicon name: mini/x-circle -->
            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="flex text-sm font-medium text-red-800">{{ $title }}</h3>
            <div class="mt-2 text-sm text-red-700">
                <ul role="list" class="list-disc space-y-1 pl-5">
                    {{ $slot }}
                </ul>
            </div>
          </div>
        </div>
      </div>
</div>