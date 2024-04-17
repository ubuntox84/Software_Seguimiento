@props(['areaKnowledge'=>''])
<li  
x-data="{ activeIndex: '',
}"
@mouseenter="activeIndex = {{ $areaKnowledge  }},console.log(activeIndex,{{ $areaKnowledge  }})"
@mouseleave="activeIndex = ''"
:class="{ 'text-white bg-indigo-600': activeIndex == {{ $areaKnowledge  }}, 'text-gray-900': !(activeIndex == {{ $areaKnowledge  }}) }"
class="text-gray-900  relative cursor-default select-none py-2 pl-8 pr-4" id="listbox-option-0" role="option">

{{-- {{  $activeIndex}} --}}
{{-- class="{{ 'activeIndex'=== $areaKnowledge->id?'text-white bg-indigo-600':'text-gray-900'}}" --}}


{{-- :class="{ 'text-white bg-indigo-600': activeIndex === 1, 'text-gray-900': !(activeIndex === 1) }" --}}
{{-- class="text-gray-900 {{ $classAdd }} relative cursor-default select-none py-2 pl-8 pr-4" id="listbox-option-0" role="option"> --}}
 <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
 <span class="font-normal block truncate">{{ $name }}</span>

 <!--
   Checkmark, only display for selected option.

   Highlighted: "text-white", Not Highlighted: "text-indigo-600"
 -->
 
 <span 
 :class="{ 'text-white': activeIndex == {{ $areaKnowledge}}, 'text-indigo-600': !(activeIndex == {{ $areaKnowledge  }}) }" 
 class="text-indigo-600 absolute inset-y-0 left-0 flex items-center pl-1.5">
   <!-- Heroicon name: mini/check -->
   <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
     <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
   </svg>
 </span>
</li>
