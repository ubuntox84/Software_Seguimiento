
<div>
  <label  class="text-base font-medium text-gray-900">{{ $title }}</label>
  <p class="text-sm leading-5 text-gray-500">
    {{ $header }}
  </p>
  <fieldset class="mt-4">
    <legend class="sr-only">Notification method</legend>
    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
     {{ $slot }}
    </div>
  </fieldset>
</div>